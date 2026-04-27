@extends('layouts.app')

@section('content')
    <section class="border-b border-white/10 py-10 lg:py-12">
        <div class="mg-container">
            <h2 class="font-display text-2xl text-white">{{ __('store.sections.shop_by') }}</h2>
            <div class="mt-8">
                <x-collection-nav style="cards" />
            </div>
        </div>
    </section>

    @php
        $slide = $heroSlides[0] ?? [];
        $title = app()->getLocale() === 'ar' ? ($slide['title_ar'] ?? __('store.hero.title')) : ($slide['title_en'] ?? __('store.hero.title'));
        $subtitle = app()->getLocale() === 'ar' ? ($slide['subtitle_ar'] ?? __('store.hero.subtitle')) : ($slide['subtitle_en'] ?? __('store.hero.subtitle'));
    @endphp

    <section class="relative overflow-hidden border-b border-white/10">
        <div class="mg-container grid items-center gap-12 py-20 lg:grid-cols-2 lg:py-28">
            <div>
                <p class="text-xs uppercase tracking-[0.45em] text-[var(--color-mg-gold)]">{{ __('store.hero.badge') }}</p>
                <h1 class="mt-6 font-display text-5xl leading-[1.05] text-white sm:text-6xl">{{ $title }}</h1>
                <p class="mt-6 max-w-xl text-base leading-relaxed text-white/70">{{ $subtitle }}</p>
                <div class="mt-10 flex flex-wrap gap-4">
                    <a class="mg-btn-primary" href="{{ route('shop') }}">{{ __('store.hero.cta_shop') }}</a>
                    <a class="mg-btn-outline" href="{{ route('contact.index') }}">{{ __('store.hero.cta_contact') }}</a>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -inset-10 -z-10 rounded-[3rem] bg-gradient-to-br from-[var(--color-mg-gold)]/25 via-transparent to-transparent blur-3xl"></div>
                <div class="rounded-[2rem] border border-white/10 bg-gradient-to-br from-white/[0.06] to-transparent p-10">
                    <div class="aspect-[4/5] rounded-2xl bg-[#111] ring-1 ring-white/10"></div>
                    <p class="mt-6 text-center text-xs uppercase tracking-[0.35em] text-white/45">{{ __('store.sections.featured') }}</p>
                </div>
            </div>
        </div>
    </section>

    @foreach ([
        ['title' => __('store.sections.featured'), 'items' => $featured],
        ['title' => __('store.sections.bestsellers'), 'items' => $bestsellers],
        ['title' => __('store.sections.new_arrivals'), 'items' => $newArrivals],
    ] as $block)
        @if ($block['items']->isNotEmpty())
            <section class="py-16">
                <div class="mg-container flex items-end justify-between gap-6">
                    <h2 class="font-display text-3xl text-white">{{ $block['title'] }}</h2>
                    <a class="text-xs uppercase tracking-[0.3em] text-[var(--color-mg-gold)] hover:text-white" href="{{ route('shop') }}">{{ __('store.buttons.view_all') }}</a>
                </div>
                <div class="mg-container mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($block['items'] as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </section>
        @endif
    @endforeach

    @if ($offers->isNotEmpty())
        <section class="border-y border-white/10 bg-white/[0.02] py-16">
            <div class="mg-container flex items-end justify-between gap-6">
                <h2 class="font-display text-3xl text-white">{{ __('store.sections.offers') }}</h2>
                <a class="text-xs uppercase tracking-[0.3em] text-[var(--color-mg-gold)]" href="{{ route('shop') }}">{{ __('store.buttons.view_all') }}</a>
            </div>
            <div class="mg-container mt-10 grid gap-6 md:grid-cols-3">
                @foreach ($offers as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    <section class="py-16">
        <div class="mg-container">
            <h2 class="font-display text-3xl text-white">{{ __('store.sections.brands') }}</h2>
            <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                @foreach ($brands as $brand)
                    <div class="rounded-2xl border border-white/10 bg-white/[0.03] px-4 py-6 text-center text-sm text-white/80">
                        @if ($brand->logo_path)
                            <img src="{{ asset('storage/'.$brand->logo_path) }}" alt="{{ $brand->localizedName() }}" class="mx-auto h-10 w-auto object-contain">
                        @else
                            <span class="tracking-[0.2em]">{{ $brand->localizedName() }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mg-container grid gap-10 lg:grid-cols-3">
            <div class="rounded-3xl border border-white/10 bg-gradient-to-b from-white/[0.05] to-transparent p-8">
                <h3 class="font-display text-2xl text-white">{{ __('store.why.authentic') }}</h3>
                <p class="mt-4 text-sm leading-relaxed text-white/65">{{ __('store.why.authentic_desc') }}</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-gradient-to-b from-white/[0.05] to-transparent p-8">
                <h3 class="font-display text-2xl text-white">{{ __('store.why.shipping') }}</h3>
                <p class="mt-4 text-sm leading-relaxed text-white/65">{{ __('store.why.shipping_desc') }}</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-gradient-to-b from-white/[0.05] to-transparent p-8">
                <h3 class="font-display text-2xl text-white">{{ __('store.why.support') }}</h3>
                <p class="mt-4 text-sm leading-relaxed text-white/65">{{ __('store.why.support_desc') }}</p>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mg-container">
            <h2 class="font-display text-3xl text-white">{{ __('store.sections.testimonials') }}</h2>
            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                @foreach ([
                    ['q' => app()->getLocale() === 'ar' ? 'خدمة راقية ومنتجات أصلية بكل تفاصيلها.' : 'Impeccable service and authentic products in every detail.', 'a' => '— Sara'],
                    ['q' => app()->getLocale() === 'ar' ? 'تجربة شراء سلسة وتغليف فاخر.' : 'A smooth purchase experience and luxurious packaging.', 'a' => '— Omar'],
                    ['q' => app()->getLocale() === 'ar' ? 'تشكيلة متنوعة من الساعات والشنط والإكسسوارات — وجهتي المفضلة.' : 'My favourite place for watches, bags, and accessories.', 'a' => '— Lina'],
                ] as $t)
                    <figure class="rounded-3xl border border-white/10 bg-black/30 p-8">
                        <blockquote class="text-sm leading-relaxed text-white/75">“{{ $t['q'] }}”</blockquote>
                        <figcaption class="mt-4 text-xs uppercase tracking-[0.25em] text-[var(--color-mg-gold)]">{{ $t['a'] }}</figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
@endsection
