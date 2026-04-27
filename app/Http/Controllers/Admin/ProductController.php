<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()->with(['brand', 'category'])->latest()->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $brands = Brand::query()->orderBy('name_en')->get();
        $categories = Category::query()->orderBy('name_en')->get();

        return view('admin.products.create', compact('brands', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->productPayload($request);
        $data['slug'] = $this->uniqueSlug($data['name_en']);

        $product = DB::transaction(function () use ($data, $request) {
            $created = Product::query()->create($data);
            $this->syncImages($created, $request);

            return $created;
        });

        return redirect()->route('admin.products.edit', $product)->with('success', __('Saved.'));
    }

    public function edit(Product $product): View
    {
        $product->load('images');
        $brands = Brand::query()->orderBy('name_en')->get();
        $categories = Category::query()->orderBy('name_en')->get();

        return view('admin.products.edit', compact('product', 'brands', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->productPayload($request);
        if ($request->boolean('regenerate_slug')) {
            $data['slug'] = $this->uniqueSlug($data['name_en'], $product->id);
        }

        DB::transaction(function () use ($product, $data, $request) {
            $product->update($data);
            $this->syncImages($product, $request);
        });

        return redirect()->route('admin.products.edit', $product)->with('success', __('Saved.'));
    }

    public function destroy(Product $product): RedirectResponse
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', __('Deleted.'));
    }

    public function deleteImage(ProductImage $image): RedirectResponse
    {
        $productId = $image->product_id;
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return redirect()->route('admin.products.edit', $productId)->with('success', __('Deleted.'));
    }

    private function productPayload(Request $request): array
    {
        $data = $request->validate([
            'brand_id' => ['required', 'exists:brands,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'name_ar' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'specifications_ar' => ['nullable', 'string'],
            'specifications_en' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'gender' => ['required', 'in:men,women,unisex'],
            'is_featured' => ['boolean'],
            'is_bestseller' => ['boolean'],
            'is_new_arrival' => ['boolean'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'],
            'regenerate_slug' => ['sometimes', 'boolean'],
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_bestseller'] = $request->boolean('is_bestseller');
        $data['is_new_arrival'] = $request->boolean('is_new_arrival');

        return $data;
    }

    private function syncImages(Product $product, Request $request): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $maxSort = (int) $product->images()->max('sort_order');
        foreach ($request->file('images', []) as $file) {
            if (! $file) {
                continue;
            }
            $maxSort++;
            $path = $file->store('products', 'public');
            ProductImage::query()->create([
                'product_id' => $product->id,
                'path' => $path,
                'sort_order' => $maxSort,
            ]);
        }
    }

    private function uniqueSlug(string $nameEn, ?int $ignoreId = null): string
    {
        $base = Str::slug($nameEn);
        $slug = $base;
        $i = 1;
        while (Product::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
