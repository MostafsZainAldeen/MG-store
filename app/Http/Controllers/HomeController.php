<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $heroSlides = Setting::getJson('hero_slides', [
            [
                'title_ar' => 'منتجاتنا تعكس أناقتك',
                'title_en' => 'Our products reflect your elegance',
                'subtitle_ar' => 'منتجات مختارة من أرقى الماركات العالمية.',
                'subtitle_en' => 'Handpicked products from the world’s finest brands — a refined shopping experience.',
                'image' => null,
            ],
        ]);

        $featured = Product::query()
            ->with(['brand', 'images'])
            ->where('is_featured', true)
            ->inStock()
            ->latest()
            ->take(8)
            ->get();

        $bestsellers = Product::query()
            ->with(['brand', 'images'])
            ->where('is_bestseller', true)
            ->inStock()
            ->orderByDesc('sales_count')
            ->take(8)
            ->get();

        $newArrivals = Product::query()
            ->with(['brand', 'images'])
            ->where('is_new_arrival', true)
            ->inStock()
            ->latest()
            ->take(8)
            ->get();

        $offers = Product::query()
            ->with(['brand', 'images'])
            ->whereNotNull('discount_price')
            ->inStock()
            ->latest()
            ->take(6)
            ->get();

        $brands = Brand::query()->orderBy('name_en')->take(12)->get();

        return view('home', compact(
            'heroSlides',
            'featured',
            'bestsellers',
            'newArrivals',
            'offers',
            'brands'
        ));
    }
}
