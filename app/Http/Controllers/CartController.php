<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use App\Services\WhatsAppMessageBuilder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private CartService $cart,
        private WhatsAppMessageBuilder $whatsapp
    ) {}

    public function index(): View
    {
        $totals = $this->cart->totals();
        $waMessage = '';
        if ($totals['lines'] !== []) {
            $lines = collect($totals['lines'])->map(function (array $line) {
                return [
                    'name' => $line['product']->localizedName(),
                    'quantity' => $line['quantity'],
                    'line_total' => $line['line_total'],
                ];
            })->all();
            $currency = (string) \App\Models\Setting::get('currency_code', 'ILS');
            $waMessage = $this->whatsapp->cartMessage(null, $lines, $totals['total'], $currency);
        }
        $whatsappUrl = $waMessage !== '' ? $this->whatsapp->urlFromText($waMessage) : $this->whatsapp->urlFromText(__('store.nav.cart'));

        return view('cart', array_merge($totals, compact('whatsappUrl')));
    }

    public function add(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['sometimes', 'integer', 'min:1', 'max:999'],
        ]);

        $product = Product::query()->findOrFail($data['product_id']);
        $qty = (int) ($data['quantity'] ?? 1);
        if ($product->stock < $qty) {
            return back()->with('error', __('store.product.out_of_stock'));
        }

        $this->cart->add($product->id, $qty);

        return back()->with('success', __('store.flash.added_to_cart'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:0', 'max:999'],
        ]);

        foreach ($data['items'] as $row) {
            $product = Product::query()->find($row['product_id']);
            if (! $product) {
                continue;
            }
            $qty = (int) $row['quantity'];
            if ($qty > $product->stock) {
                $qty = $product->stock;
            }
            $this->cart->update((int) $row['product_id'], $qty);
        }

        return back()->with('success', __('store.buttons.update'));
    }

    public function remove(int $product): RedirectResponse
    {
        $this->cart->remove($product);

        return back()->with('success', __('store.buttons.remove'));
    }

    public function buyNow(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['sometimes', 'integer', 'min:1', 'max:999'],
        ]);

        $product = Product::query()->findOrFail($data['product_id']);
        $qty = (int) ($data['quantity'] ?? 1);
        if ($product->stock < $qty) {
            return back()->with('error', __('store.product.out_of_stock'));
        }

        $this->cart->clear();
        $this->cart->add($product->id, $qty);

        return redirect()->route('checkout.index')->with('success', __('store.flash.added_to_cart'));
    }

    public function coupon(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['nullable', 'string', 'max:64'],
        ]);
        $this->cart->setCoupon($data['code'] ?? null);
        if (($data['code'] ?? '') !== '' && ! $this->cart->resolveCoupon()) {
            return back()->with('error', __('store.coupon_invalid'));
        }

        return back()->with('success', __('store.buttons.apply'));
    }
}
