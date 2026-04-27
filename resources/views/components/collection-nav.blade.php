@props(['style' => 'bar'])

@php
    $items = [
        ['label' => __('store.nav.mens'), 'url' => route('shop', ['gender' => 'men'])],
        ['label' => __('store.nav.womens'), 'url' => route('shop', ['gender' => 'women'])],
        ['label' => __('store.nav.bags'), 'url' => route('shop', ['category_slug' => 'bags'])],
        ['label' => __('store.nav.accessories'), 'url' => route('shop', ['category_slug' => 'accessories'])],
        ['label' => __('store.nav.wallets'), 'url' => route('shop', ['category_slug' => 'wallets'])],
    ];
@endphp

@if ($style === 'bar')
    <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-xs font-medium uppercase tracking-[0.2em] text-white/55">
        <span class="text-white/35 max-lg:hidden">{{ __('store.nav.collections') }}:</span>
        @foreach ($items as $item)
            <a class="whitespace-nowrap text-white/70 transition hover:text-[var(--color-mg-gold)]" href="{{ $item['url'] }}">{{ $item['label'] }}</a>
        @endforeach
    </div>
@else
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        @foreach ($items as $item)
            <a href="{{ $item['url'] }}" class="group rounded-2xl border border-white/10 bg-white/[0.03] px-5 py-6 text-center transition hover:border-[var(--color-mg-gold)]/40">
                <span class="text-sm font-medium text-white/90 group-hover:text-[var(--color-mg-gold)]">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
@endif
