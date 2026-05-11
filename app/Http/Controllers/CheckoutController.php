<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Services\CartService;
use App\Services\WhatsAppMessageBuilder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use RuntimeException;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cart,
        private WhatsAppMessageBuilder $whatsapp
    ) {}

    public function index(): View|RedirectResponse
    {
        $totals = $this->cart->totals();
        if ($totals['lines'] === [] || $totals['total'] <= 0) {
            return redirect()->route('cart.index')->with('error', __('store.cart.empty'));
        }

        $currency = (string) Setting::get('currency_code', 'ILS');
        $lines = collect($totals['lines'])->map(function (array $line) {
            return [
                'name' => $line['product']->localizedName(),
                'quantity' => $line['quantity'],
                'line_total' => $line['line_total'],
            ];
        })->all();

        $waMessage = $this->whatsapp->cartMessage(null, $lines, $totals['total'], $currency);
        $whatsappUrl = $this->whatsapp->urlFromText($waMessage);

        return view('checkout', array_merge($totals, compact('currency', 'whatsappUrl')));
    }

    public function store(StoreCheckoutRequest $request): RedirectResponse
    {
        $totals = $this->cart->totals();
        if ($totals['lines'] === [] || $totals['total'] <= 0) {
            return redirect()->route('cart.index')->with('error', __('store.cart.empty'));
        }

        $currency = (string) Setting::get('currency_code', 'ILS');

        try {
            $order = DB::transaction(function () use ($request, $totals, $currency) {
                $order = Order::query()->create([
                    'order_number' => Order::generateOrderNumber(),
                    'full_name' => $request->input('full_name'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'notes' => $request->input('notes'),
                    'delivery_details' => $request->input('delivery_details'),
                    'status' => 'pending',
                    'subtotal' => $totals['subtotal'],
                    'discount_amount' => $totals['discount'],
                    'total' => $totals['total'],
                    'currency' => $currency,
                    'coupon_id' => $totals['coupon']?->id,
                ]);

                foreach ($totals['lines'] as $line) {
                    $locked = Product::query()->whereKey($line['product']->id)->lockForUpdate()->first();
                    if (! $locked) {
                        throw new RuntimeException('missing_product');
                    }
                    $qty = $line['quantity'];
                    if ($locked->stock < $qty) {
                        throw new RuntimeException('insufficient_stock');
                    }

                    OrderItem::query()->create([
                        'order_id' => $order->id,
                        'product_id' => $locked->id,
                        'name_ar' => $locked->name_ar,
                        'name_en' => $locked->name_en,
                        'quantity' => $qty,
                        'unit_price' => $locked->currentPrice(),
                        'line_total' => $line['line_total'],
                    ]);

                    $locked->decrement('stock', $qty);
                    $locked->incrementSales($qty);
                }

                return $order;
            });
        } catch (RuntimeException) {
            return redirect()->route('cart.index')->with('error', __('store.stock_issue'));
        }

        $this->cart->clear();

        return redirect()
            ->route('checkout.success', ['orderNumber' => $order->order_number])
            ->with('success', __('store.checkout.order_success'));
    }

    public function success(string $orderNumber): View
    {
        $model = Order::query()->where('order_number', $orderNumber)->with('items')->firstOrFail();
        $whatsappUrl = $this->whatsapp->urlFromText($this->whatsapp->orderMessage($model));

        return view('checkout-success', compact('model', 'whatsappUrl'));
    }
}
