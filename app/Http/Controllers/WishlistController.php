<?php

namespace App\Http\Controllers;

use App\Services\WishlistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function __construct(
        private WishlistService $wishlist
    ) {}

    public function index(): View
    {
        $products = $this->wishlist->products();

        return view('wishlist', compact('products'));
    }

    public function toggle(int $product): RedirectResponse
    {
        $this->wishlist->toggle($product);

        return back();
    }
}
