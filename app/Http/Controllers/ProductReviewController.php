<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductReviewRequest;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\RedirectResponse;

class ProductReviewController extends Controller
{
    public function store(StoreProductReviewRequest $request, string $slug): RedirectResponse
    {
        $product = Product::query()->where('slug', $slug)->firstOrFail();

        ProductReview::query()->create([
            'product_id' => $product->id,
            'author_name' => $request->input('author_name'),
            'rating' => (int) $request->input('rating'),
            'comment' => $request->input('comment'),
            'is_approved' => false,
        ]);

        return back()->with('success', __('store.review_thanks'));
    }
}
