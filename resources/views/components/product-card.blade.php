@props(['product'])

@php
    $img = $product->primaryImage();
    $href = route('product.show', $product->slug);
@endphp

<article {{ $attributes->merge(['class' => 'mg-card group']) }}>
    <a href="{{ $href }}" class="block">
        <div class="relative aspect-[4/5] overflow-hidden bg-[#111]">
            @if ($img)
                <img src="{{ asset('storage/'.$img->path) }}" alt="{{ $product->localizedName() }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105" loading="lazy">
            @else
                <div class="flex h-full w-full items-center justify-center text-xs text-white/35">{{ __('store.site_name') }}</div>
            @endif
            @if ($product->hasDiscount())
                <span class="absolute left-4 top-4 rounded-full bg-[var(--color-mg-gold)] px-3 py-1 text-[11px] font-semibold text-black">{{ __('store.sections.offers') }}</span>
            @endif
        </div>
        <div class="space-y-2 p-5">
            <p class="text-[11px] uppercase tracking-[0.3em] text-[var(--color-mg-muted)]">{{ $product->brand?->localizedName() }}</p>
            <h3 class="font-display text-xl text-white">{{ $product->localizedName() }}</h3>
            <div class="flex items-baseline gap-3">
                <span class="text-[var(--color-mg-gold)]">{{ number_format($product->currentPrice(), 2) }} {{ $currencyCode ?? 'ILS' }}</span>
                @if ($product->hasDiscount())
                    <span class="text-sm text-white/35 line-through">{{ number_format((float) $product->price, 2) }}</span>
                @endif
            </div>
        </div>
    </a>
    <div class="flex items-center justify-between gap-2 border-t border-white/10 px-5 pb-5">
        <form action="{{ route('cart.add') }}" method="post" class="flex-1">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="mg-btn-outline w-full py-2 text-xs">{{ __('store.buttons.add_to_cart') }}</button>
        </form>
        <form action="{{ route('wishlist.toggle', $product->id) }}" method="post">
            @csrf
            <button type="submit" class="rounded-full border border-white/10 p-2 text-white/70 hover:border-[var(--color-mg-gold)] hover:text-[var(--color-mg-gold)]" title="{{ __('store.nav.wishlist') }}">♥</button>
        </form>
    </div>
</article>
