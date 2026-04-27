<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="{{ app()->getLocale() === 'ar' ? 'font-ar' : 'font-en' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', ($metaTitle ?? config('app.name')).' — '.__('store.meta_title_suffix'))</title>
    <meta name="description" content="@yield('meta_description', app()->getLocale() === 'ar' ? ($metaDescriptionAr ?? '') : ($metaDescriptionEn ?? ''))">
    @stack('meta')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=tajawal:400,500,600,700|dm-sans:400,500,600,700|cormorant-garamond:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
    <div class="pointer-events-none fixed inset-0 -z-10 bg-[radial-gradient(ellipse_at_top,_rgba(201,169,98,0.12),_transparent_55%),radial-gradient(ellipse_at_bottom,_rgba(255,255,255,0.06),_transparent_45%)]"></div>

    <header class="sticky top-0 z-50 border-b border-white/10 bg-[#0a0a0a]/80 backdrop-blur-xl">
        <div class="mg-container flex items-center justify-between gap-4 py-4">
            <a href="{{ route('home') }}" class="group flex items-center gap-3">
                @if (!empty($siteLogo))
                    <img src="{{ asset('storage/'.$siteLogo) }}" alt="{{ __('store.site_name') }}" class="h-9 w-auto">
                @else
                    <span class="font-display text-2xl tracking-[0.25em] text-[var(--color-mg-gold)]">MG</span>
                @endif
                <span class="hidden text-xs uppercase tracking-[0.35em] text-white/70 sm:block">{{ __('store.site_name') }}</span>
            </a>

            <nav class="hidden items-center gap-6 text-sm text-white/80 lg:flex">
                <a class="hover:text-[var(--color-mg-gold)] transition" href="{{ route('home') }}">{{ __('store.nav.home') }}</a>
                <a class="hover:text-[var(--color-mg-gold)] transition" href="{{ route('shop') }}">{{ __('store.nav.shop') }}</a>
                <a class="hover:text-[var(--color-mg-gold)] transition" href="{{ route('about') }}">{{ __('store.nav.about') }}</a>
                <a class="hover:text-[var(--color-mg-gold)] transition" href="{{ route('contact.index') }}">{{ __('store.nav.contact') }}</a>
            </nav>

            <div class="flex items-center gap-2 sm:gap-3">
                <div class="flex items-center rounded-full border border-white/10 bg-white/[0.03] p-1 text-[11px] font-semibold uppercase tracking-widest">
                    <a href="{{ route('locale.switch', 'ar') }}" class="rounded-full px-3 py-1 {{ app()->getLocale() === 'ar' ? 'bg-[var(--color-mg-gold)] text-black' : 'text-white/60 hover:text-white' }}">عربي</a>
                    <a href="{{ route('locale.switch', 'en') }}" class="rounded-full px-3 py-1 {{ app()->getLocale() === 'en' ? 'bg-[var(--color-mg-gold)] text-black' : 'text-white/60 hover:text-white' }}">EN</a>
                </div>

                <a href="{{ route('wishlist.index') }}" class="relative rounded-full border border-white/10 p-2 text-white/80 hover:border-[var(--color-mg-gold)]/50 hover:text-[var(--color-mg-gold)] transition" title="{{ __('store.nav.wishlist') }}">
                    <span class="sr-only">{{ __('store.nav.wishlist') }}</span>
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="1.5" d="M12 21s-6.716-3.96-9-8.5S4.5 3.5 8.25 3.5c1.834 0 3.203.9 3.75 2.1.547-1.2 1.916-2.1 3.75-2.1 3.75 0 5.25 4.5 2.75 9S12 21 12 21Z"/></svg>
                    @if (($wishlistCount ?? 0) > 0)
                        <span class="absolute -right-1 -top-1 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-[var(--color-mg-gold)] px-1 text-[10px] font-bold text-black">{{ $wishlistCount }}</span>
                    @endif
                </a>

                <a href="{{ route('cart.index') }}" class="relative rounded-full border border-white/10 p-2 text-white/80 hover:border-[var(--color-mg-gold)]/50 hover:text-[var(--color-mg-gold)] transition" title="{{ __('store.nav.cart') }}">
                    <span class="sr-only">{{ __('store.nav.cart') }}</span>
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="1.5" d="M6 7h15l-1.5 9h-12L6 7Zm0 0L5 3H2"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg>
                    @if (($cartCount ?? 0) > 0)
                        <span class="absolute -right-1 -top-1 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-[var(--color-mg-gold)] px-1 text-[10px] font-bold text-black">{{ $cartCount }}</span>
                    @endif
                </a>

                <button type="button" class="lg:hidden rounded-full border border-white/10 p-2 text-white/80" data-mg-nav-toggle aria-expanded="false" aria-controls="mg-mobile-nav">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="1.5" d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </div>
        </div>
        @unless (request()->routeIs('home'))
            <div class="border-t border-white/10 bg-black/30">
                <div class="mg-container overflow-x-auto py-3">
                    <x-collection-nav style="bar" />
                </div>
            </div>
        @endunless
        <div id="mg-mobile-nav" class="hidden border-t border-white/10 lg:hidden">
            <div class="mg-container flex flex-col gap-2 py-4 text-sm text-white/85">
                <a class="py-1" href="{{ route('home') }}">{{ __('store.nav.home') }}</a>
                <a class="py-1" href="{{ route('shop') }}">{{ __('store.nav.shop') }}</a>
                <p class="pt-2 text-[10px] uppercase tracking-[0.25em] text-white/40">{{ __('store.nav.collections') }}</p>
                <a class="py-1 pl-1" href="{{ route('shop', ['gender' => 'men']) }}">{{ __('store.nav.mens') }}</a>
                <a class="py-1 pl-1" href="{{ route('shop', ['gender' => 'women']) }}">{{ __('store.nav.womens') }}</a>
                <a class="py-1 pl-1" href="{{ route('shop', ['category_slug' => 'bags']) }}">{{ __('store.nav.bags') }}</a>
                <a class="py-1 pl-1" href="{{ route('shop', ['category_slug' => 'accessories']) }}">{{ __('store.nav.accessories') }}</a>
                <a class="py-1 pl-1" href="{{ route('shop', ['category_slug' => 'wallets']) }}">{{ __('store.nav.wallets') }}</a>
                <a class="py-1 pt-2" href="{{ route('about') }}">{{ __('store.nav.about') }}</a>
                <a class="py-1" href="{{ route('contact.index') }}">{{ __('store.nav.contact') }}</a>
            </div>
        </div>
    </header>

    @if (session('success'))
        <div class="mg-container pt-6">
            <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-100">{{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="mg-container pt-6">
            <div class="rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-100">{{ session('error') }}</div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="mt-20 border-t border-white/10 bg-black/40">
        <div class="mg-container grid gap-12 py-16 md:grid-cols-3">
            <div>
                <p class="font-display text-2xl text-[var(--color-mg-gold)]">MG Store</p>
                <p class="mt-4 text-sm leading-relaxed text-white/65">{{ __('store.hero.subtitle') }}</p>
            </div>
            <div>
                <p class="mg-label">{{ __('store.contact.address') }}</p>
                <p class="text-sm text-white/75">{{ app()->getLocale() === 'ar' ? ($addressAr ?? '—') : ($addressEn ?? '—') }}</p>
                @if (!empty($sitePhone))
                    <p class="mt-4 text-sm text-white/75"><span class="text-white/45">{{ __('store.contact.phone') }}:</span> {{ $sitePhone }}</p>
                @endif
            </div>
            <div>
                <p class="mg-label">{{ __('store.sections.newsletter') }}</p>
                <form action="{{ route('newsletter.store') }}" method="post" class="mt-3 flex flex-col gap-3 sm:flex-row">
                    @csrf
                    <input class="mg-input sm:flex-1" type="email" name="email" required placeholder="email@example.com">
                    <button class="mg-btn-primary shrink-0" type="submit">{{ __('store.buttons.subscribe') }}</button>
                </form>
                <div class="mt-6 flex flex-wrap gap-3 text-xs uppercase tracking-widest text-white/55">
                    @if (!empty($socialInstagram))
                        <a class="hover:text-[var(--color-mg-gold)]" href="{{ $socialInstagram }}" target="_blank" rel="noopener">Instagram</a>
                    @endif
                    @if (!empty($socialFacebook))
                        <a class="hover:text-[var(--color-mg-gold)]" href="{{ $socialFacebook }}" target="_blank" rel="noopener">Facebook</a>
                    @endif
                    @if (!empty($socialTwitter))
                        <a class="hover:text-[var(--color-mg-gold)]" href="{{ $socialTwitter }}" target="_blank" rel="noopener">X</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="border-t border-white/10 py-6 text-center text-xs text-white/40">
            © {{ date('Y') }} {{ __('store.site_name') }}. {{ __('store.footer.rights') }}
        </div>
    </footer>

    <script>
        document.querySelector('[data-mg-nav-toggle]')?.addEventListener('click', () => {
            const panel = document.getElementById('mg-mobile-nav');
            if (!panel) return;
            panel.classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>
