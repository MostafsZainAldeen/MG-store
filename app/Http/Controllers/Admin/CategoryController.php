<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()->latest()->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name_en']);

        Category::query()->create($data);

        return redirect()->route('admin.categories.index')->with('success', __('Saved.'));
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validated($request);
        if ($request->boolean('regenerate_slug')) {
            $data['slug'] = $this->uniqueSlug($data['name_en'], $category->id);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', __('Saved.'));
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return back()->with('error', __('Cannot delete category with products.'));
        }
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', __('Deleted.'));
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name_ar' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'regenerate_slug' => ['sometimes', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $nameEn, ?int $ignoreId = null): string
    {
        $base = Str::slug($nameEn);
        $slug = $base;
        $i = 1;
        while (Category::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
