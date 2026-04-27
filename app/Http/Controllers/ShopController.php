<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function __invoke(Request $request): View
    {
        $q = $request->string('q')->trim()->toString();
        $brandId = $request->integer('brand') ?: null;
        $categoryId = $request->integer('category') ?: null;
        $categorySlug = $request->string('category_slug')->trim()->toString();
        if ($categorySlug !== '') {
            $resolved = Category::query()->where('slug', $categorySlug)->value('id');
            if ($resolved) {
                $categoryId = (int) $resolved;
            }
        }
        $gender = $request->string('gender')->toString();
        $minPrice = $request->filled('min_price') ? (float) $request->input('min_price') : null;
        $maxPrice = $request->filled('max_price') ? (float) $request->input('max_price') : null;
        $sort = $request->string('sort', 'latest')->toString();

        $query = Product::query()->with(['brand', 'category', 'images']);

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('name_ar', 'like', '%'.$q.'%')
                    ->orWhere('name_en', 'like', '%'.$q.'%')
                    ->orWhere('description_ar', 'like', '%'.$q.'%')
                    ->orWhere('description_en', 'like', '%'.$q.'%');
            });
        }

        if ($brandId) {
            $query->where('brand_id', $brandId);
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if (in_array($gender, ['men', 'women', 'unisex'], true)) {
            $query->where('gender', $gender);
        }

        $effectivePriceSql = 'COALESCE(CASE WHEN discount_price IS NOT NULL AND discount_price < price THEN discount_price ELSE NULL END, price)';

        if ($minPrice !== null) {
            $query->whereRaw($effectivePriceSql.' >= ?', [$minPrice]);
        }
        if ($maxPrice !== null) {
            $query->whereRaw($effectivePriceSql.' <= ?', [$maxPrice]);
        }

        match ($sort) {
            'price_asc' => $query->orderByRaw($effectivePriceSql.' asc'),
            'price_desc' => $query->orderByRaw($effectivePriceSql.' desc'),
            'bestseller' => $query->orderByDesc('sales_count')->orderByDesc('created_at'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        $brands = Brand::query()->orderBy('name_en')->get();
        $categories = Category::query()->orderBy('name_en')->get();

        return view('shop', compact('products', 'brands', 'categories', 'categoryId'));
    }
}
