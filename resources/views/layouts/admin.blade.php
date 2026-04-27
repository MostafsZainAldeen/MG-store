<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — MG Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#0a0a0a] text-[#f5f5f0]">
    @auth('admin')
        <header class="border-b border-white/10 bg-black/40">
            <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-4 py-4">
                <a href="{{ route('admin.dashboard') }}" class="font-display text-xl text-[var(--color-mg-gold)]">MG Admin</a>
                <a class="text-xs text-white/45 hover:text-white" href="{{ route('home') }}" target="_blank">View site</a>
                <nav class="flex flex-wrap items-center gap-4 text-sm text-white/75">
                    <a class="hover:text-white" href="{{ route('admin.products.index') }}">Products</a>
                    <a class="hover:text-white" href="{{ route('admin.brands.index') }}">Brands</a>
                    <a class="hover:text-white" href="{{ route('admin.categories.index') }}">Categories</a>
                    <a class="hover:text-white" href="{{ route('admin.orders.index') }}">Orders</a>
                    <a class="hover:text-white" href="{{ route('admin.coupons.index') }}">Coupons</a>
                    <a class="hover:text-white" href="{{ route('admin.reviews.index') }}">Reviews</a>
                    <a class="hover:text-white" href="{{ route('admin.settings.edit') }}">Settings</a>
                    <form action="{{ route('admin.logout') }}" method="post">@csrf<button class="text-red-300 hover:text-red-200" type="submit">Logout</button></form>
                </nav>
            </div>
        </header>
    @endauth

    <main class="mx-auto max-w-7xl px-4 py-10">
        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-100">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-6 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-100">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>
