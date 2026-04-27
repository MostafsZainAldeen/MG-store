@php
    $p = $product;
@endphp

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="mg-label">Brand</label>
        <select class="mg-input" name="brand_id" required>
            @foreach ($brands as $b)
                <option value="{{ $b->id }}" @selected(old('brand_id', $p?->brand_id) == $b->id)>{{ $b->name_en }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="mg-label">Category</label>
        <select class="mg-input" name="category_id" required>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $p?->category_id) == $c->id)>{{ $c->name_en }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="mg-label">Name (AR)</label>
        <input class="mg-input" name="name_ar" value="{{ old('name_ar', $p?->name_ar) }}" required>
    </div>
    <div>
        <label class="mg-label">Name (EN)</label>
        <input class="mg-input" name="name_en" value="{{ old('name_en', $p?->name_en) }}" required>
    </div>
</div>

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="mg-label">Description (AR)</label>
        <textarea class="mg-input min-h-[120px]" name="description_ar">{{ old('description_ar', $p?->description_ar) }}</textarea>
    </div>
    <div>
        <label class="mg-label">Description (EN)</label>
        <textarea class="mg-input min-h-[120px]" name="description_en">{{ old('description_en', $p?->description_en) }}</textarea>
    </div>
</div>

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="mg-label">Specifications (AR)</label>
        <textarea class="mg-input min-h-[100px]" name="specifications_ar">{{ old('specifications_ar', $p?->specifications_ar) }}</textarea>
    </div>
    <div>
        <label class="mg-label">Specifications (EN)</label>
        <textarea class="mg-input min-h-[100px]" name="specifications_en">{{ old('specifications_en', $p?->specifications_en) }}</textarea>
    </div>
</div>

<div class="grid gap-4 md:grid-cols-3">
    <div>
        <label class="mg-label">Price</label>
        <input class="mg-input" type="number" step="0.01" name="price" value="{{ old('price', $p?->price) }}" required>
    </div>
    <div>
        <label class="mg-label">Discount price</label>
        <input class="mg-input" type="number" step="0.01" name="discount_price" value="{{ old('discount_price', $p?->discount_price) }}">
    </div>
    <div>
        <label class="mg-label">Stock</label>
        <input class="mg-input" type="number" name="stock" value="{{ old('stock', $p?->stock ?? 0) }}" required>
    </div>
</div>

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="mg-label">Gender</label>
        <select class="mg-input" name="gender">
            @foreach (['men' => 'Men', 'women' => 'Women', 'unisex' => 'Unisex'] as $val => $label)
                <option value="{{ $val }}" @selected(old('gender', $p?->gender) === $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid grid-cols-3 gap-3 pt-8">
        <label class="flex items-center gap-2 text-sm text-white/75">
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $p?->is_featured))>
            Featured
        </label>
        <label class="flex items-center gap-2 text-sm text-white/75">
            <input type="hidden" name="is_bestseller" value="0">
            <input type="checkbox" name="is_bestseller" value="1" @checked(old('is_bestseller', $p?->is_bestseller))>
            Best seller
        </label>
        <label class="flex items-center gap-2 text-sm text-white/75">
            <input type="hidden" name="is_new_arrival" value="0">
            <input type="checkbox" name="is_new_arrival" value="1" @checked(old('is_new_arrival', $p?->is_new_arrival))>
            New
        </label>
    </div>
</div>

<div>
    <label class="mg-label">Images (multiple)</label>
    <input class="mg-input" type="file" name="images[]" multiple accept="image/*">
</div>
