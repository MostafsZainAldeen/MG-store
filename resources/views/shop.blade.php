@extends('layouts.app')

@section('title', __('store.shop.title'))

@section('content')
    <section class="border-b border-white/10 py-14">
        <div class="mg-container">
            <h1 class="font-display text-4xl text-white">{{ __('store.shop.title') }}</h1>
            <p class="mt-3 text-sm text-white/55">{{ $products->total() }} {{ __('store.shop.results') }}</p>
        </div>
    </section>

    <section class="py-10">
        <div class="mg-container grid gap-10 lg:grid-cols-[280px_1fr]">
            <form method="get" class="space-y-6 rounded-3xl border border-white/10 bg-white/[0.03] p-6">
                <div>
                    <label class="mg-label">{{ __('store.buttons.search') }}</label>
                    <input class="mg-input" type="search" name="q" value="{{ request('q') }}" placeholder="…">
                </div>
                <div>
                    <label class="mg-label">{{ __('store.shop.filters') }}</label>
                    <select class="mg-input" name="brand">
                        <option value="">{{ __('store.shop.filters') }}</option>
                        @foreach ($brands as $b)
                            <option value="{{ $b->id }}" @selected((string) request('brand') === (string) $b->id)>{{ $b->localizedName() }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                        <label class="mg-label">{{ __('store.product.category') }}</label>
                    <select class="mg-input" name="category">
                        <option value="">—</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}" @selected((string) (request('category') ?? ($categoryId ?? '')) === (string) $c->id)>{{ $c->localizedName() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="mg-label">{{ __('store.shop.price_from') }}</label>
                        <input class="mg-input" type="number" step="0.01" name="min_price" value="{{ request('min_price') }}">
                    </div>
                    <div>
                        <label class="mg-label">{{ __('store.shop.price_to') }}</label>
                        <input class="mg-input" type="number" step="0.01" name="max_price" value="{{ request('max_price') }}">
                    </div>
                </div>
                <div>
                    <label class="mg-label">{{ __('store.shop.gender') }}</label>
                    <select class="mg-input" name="gender">
                        <option value="">—</option>
                        <option value="men" @selected(request('gender') === 'men')>{{ __('store.shop.gender_men') }}</option>
                        <option value="women" @selected(request('gender') === 'women')>{{ __('store.shop.gender_women') }}</option>
                        <option value="unisex" @selected(request('gender') === 'unisex')>{{ __('store.shop.gender_unisex') }}</option>
                    </select>
                </div>
                <div>
                    <label class="mg-label">{{ __('store.buttons.sort') }}</label>
                    <select class="mg-input" name="sort">
                        <option value="latest" @selected(request('sort', 'latest') === 'latest')>{{ __('store.shop.sort_latest') }}</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>{{ __('store.shop.sort_price_asc') }}</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>{{ __('store.shop.sort_price_desc') }}</option>
                        <option value="bestseller" @selected(request('sort') === 'bestseller')>{{ __('store.shop.sort_bestseller') }}</option>
                    </select>
                </div>
                <button class="mg-btn-primary w-full" type="submit">{{ __('store.buttons.filter') }}</button>
            </form>

            <div>
                @if ($products->isEmpty())
                    <p class="text-white/60">{{ __('store.shop.no_products') }}</p>
                @else
                    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                    <div class="mt-10">
                        {{ $products->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
