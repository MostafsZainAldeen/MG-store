@extends('layouts.app')

@section('title', $product->localizedName())

@section('content')
    @php
        $images = $product->images;
        $primary = $images->first();
    @endphp

    <section class="py-12">
        <div class="mg-container grid gap-12 lg:grid-cols-2">
            <div class="space-y-4">
                <div class="overflow-hidden rounded-3xl border border-white/10 bg-[#111]">
                    @if ($primary)
                        <img id="mg-main-image" src="{{ asset('storage/'.$primary->path) }}" alt="{{ $product->localizedName() }}" class="aspect-[4/5] w-full object-cover">
                    @else
                        <div class="flex aspect-[4/5] items-center justify-center text-white/30">{{ __('store.site_name') }}</div>
                    @endif
                </div>
                @if ($images->count() > 1)
                    <div class="grid grid-cols-4 gap-3">
                        @foreach ($images as $img)
                            <button type="button" class="overflow-hidden rounded-xl border border-white/10" data-mg-thumb="{{ asset('storage/'.$img->path) }}">
                                <img src="{{ asset('storage/'.$img->path) }}" class="h-20 w-full object-cover" alt="">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-[var(--color-mg-muted)]">{{ $product->brand?->localizedName() }}</p>
                <h1 class="mt-4 font-display text-4xl text-white lg:text-5xl">{{ $product->localizedName() }}</h1>
                <div class="mt-6 flex items-baseline gap-4">
                    <span class="text-3xl text-[var(--color-mg-gold)]">{{ number_format($product->currentPrice(), 2) }} {{ $currency }}</span>
                    @if ($product->hasDiscount())
                        <span class="text-lg text-white/35 line-through">{{ number_format((float) $product->price, 2) }}</span>
                    @endif
                </div>

                <div class="mt-8 space-y-3 text-sm text-white/70">
                    <p><span class="text-white/45">{{ __('store.product.category') }}:</span> {{ $product->category?->localizedName() }}</p>
                    <p><span class="text-white/45">{{ __('store.product.stock') }}:</span>
                        @if ($product->stock > 0)
                            <span class="text-emerald-300">{{ __('store.product.in_stock') }} ({{ $product->stock }})</span>
                        @else
                            <span class="text-red-300">{{ __('store.product.out_of_stock') }}</span>
                        @endif
                    </p>
                </div>

                @if ($product->localizedDescription())
                    <div class="mt-10">
                        <h2 class="mg-label">{{ __('store.product.description') }}</h2>
                        <div class="prose prose-invert mt-3 max-w-none text-sm leading-relaxed text-white/75">{!! nl2br(e($product->localizedDescription())) !!}</div>
                    </div>
                @endif

                @if ($product->localizedSpecifications())
                    <div class="mt-8">
                        <h2 class="mg-label">{{ __('store.product.specs') }}</h2>
                        <div class="mt-3 rounded-2xl border border-white/10 bg-white/[0.03] p-5 text-sm text-white/75">{!! nl2br(e($product->localizedSpecifications())) !!}</div>
                    </div>
                @endif

                <div class="mt-10 flex flex-wrap gap-4">
                    <form action="{{ route('cart.add') }}" method="post" class="flex items-end gap-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div>
                            <label class="mg-label">{{ __('store.product.qty') }}</label>
                            <input class="mg-input w-28" type="number" name="quantity" value="1" min="1" max="{{ max(1, $product->stock) }}">
                        </div>
                        <button class="mg-btn-primary" type="submit" @disabled($product->stock < 1)>{{ __('store.buttons.add_to_cart') }}</button>
                    </form>

                    <form action="{{ route('cart.buy_now') }}" method="post" class="flex items-end gap-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button class="mg-btn-outline" type="submit" @disabled($product->stock < 1)>{{ __('store.buttons.buy_now') }}</button>
                    </form>

                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="post">
                        @csrf
                        <button class="mg-btn-outline" type="submit">{{ __('store.nav.wishlist') }}</button>
                    </form>

                    <a class="mg-btn-outline" href="{{ $whatsappUrl }}" target="_blank" rel="noopener">{{ __('store.buttons.whatsapp') }}</a>
                </div>
            </div>
        </div>
    </section>

    @if ($product->approvedReviews->isNotEmpty())
        <section class="border-t border-white/10 py-12">
            <div class="mg-container">
                <h2 class="font-display text-3xl text-white">{{ __('store.product.reviews') }}</h2>
                <div class="mt-8 grid gap-4">
                    @foreach ($product->approvedReviews as $review)
                        <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-sm font-semibold text-white">{{ $review->author_name }}</p>
                                <p class="text-xs text-[var(--color-mg-gold)]">{{ str_repeat('★', $review->rating) }}</p>
                            </div>
                            @if ($review->comment)
                                <p class="mt-3 text-sm text-white/70">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="border-t border-white/10 py-12">
        <div class="mg-container max-w-3xl">
            <h2 class="font-display text-2xl text-white">{{ __('store.product.write_review') }}</h2>
            <form action="{{ route('product.reviews.store', $product->slug) }}" method="post" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="mg-label">{{ __('Name') }}</label>
                    <input class="mg-input" type="text" name="author_name" value="{{ old('author_name') }}" required>
                </div>
                <div>
                    <label class="mg-label">{{ __('Rating') }}</label>
                    <select class="mg-input" name="rating" required>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="mg-label">{{ __('Comment') }}</label>
                    <textarea class="mg-input min-h-[120px]" name="comment">{{ old('comment') }}</textarea>
                </div>
                <button class="mg-btn-primary" type="submit">{{ __('store.buttons.send') }}</button>
            </form>
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="border-t border-white/10 py-16">
            <div class="mg-container flex items-end justify-between gap-6">
                <h2 class="font-display text-3xl text-white">{{ __('store.product.related') }}</h2>
            </div>
            <div class="mg-container mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($related as $rp)
                    <x-product-card :product="$rp" />
                @endforeach
            </div>
        </section>
    @endif
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('[data-mg-thumb]').forEach((btn) => {
            btn.addEventListener('click', () => {
                const src = btn.getAttribute('data-mg-thumb');
                const main = document.getElementById('mg-main-image');
                if (main && src) main.setAttribute('src', src);
            });
        });
    </script>
@endpush
