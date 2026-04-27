<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductReviewController extends Controller
{
    public function index(): View
    {
        $reviews = ProductReview::query()->with('product')->latest()->paginate(30);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(ProductReview $review): RedirectResponse
    {
        $review->update(['is_approved' => true]);

        return back()->with('success', __('Saved.'));
    }

    public function reject(ProductReview $review): RedirectResponse
    {
        $review->delete();

        return back()->with('success', __('Deleted.'));
    }
}
