@extends('layouts.app')

@section('title', __('store.nav.wishlist'))

@section('content')
    <section class="py-14">
        <div class="mg-container">
            <h1 class="font-display text-4xl text-white">{{ __('store.nav.wishlist') }}</h1>

            @if ($products->isEmpty())
                <p class="mt-8 text-white/60">—</p>
                <a class="mg-btn-primary mt-6 inline-flex" href="{{ route('shop') }}">{{ __('store.buttons.continue_shopping') }}</a>
            @else
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
