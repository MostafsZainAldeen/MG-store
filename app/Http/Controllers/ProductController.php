<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use App\Services\WhatsAppMessageBuilder;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private WhatsAppMessageBuilder $whatsapp
    ) {}

    public function show(string $slug): View
    {
        $product = Product::query()
            ->with(['brand', 'category', 'images', 'approvedReviews'])
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Product::query()
            ->with(['brand', 'images'])
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                $q->where('category_id', $product->category_id)
                    ->orWhere('brand_id', $product->brand_id);
            })
            ->inStock()
            ->take(8)
            ->get();

        $currency = (string) Setting::get('currency_code', 'SAR');
        $lines = [[
            'name' => $product->localizedName(),
            'quantity' => 1,
            'line_total' => $product->currentPrice(),
        ]];
        $waMessage = $this->whatsapp->cartMessage(null, $lines, $product->currentPrice(), $currency);
        $whatsappUrl = $this->whatsapp->urlFromText($waMessage);

        return view('product', compact('product', 'related', 'whatsappUrl', 'currency'));
    }
}
