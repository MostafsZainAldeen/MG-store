@extends('layouts.app')

@section('title', __('store.checkout.order_success'))

@section('content')
    <section class="py-20">
        <div class="mg-container max-w-2xl text-center">
            <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-mg-gold)]">{{ __('store.checkout.order_success') }}</p>
            <h1 class="mt-6 font-display text-4xl text-white">{{ __('store.checkout.order_number') }}</h1>
            <p class="mt-4 text-2xl text-white/85">{{ $model->order_number }}</p>
            <p class="mt-6 text-sm text-white/60">{{ __('store.checkout.cod') }}</p>
            <div class="mt-10 flex flex-col gap-4 sm:flex-row sm:justify-center">
                <a class="mg-btn-primary" href="{{ route('shop') }}">{{ __('store.buttons.continue_shopping') }}</a>
                <a class="mg-btn-outline" href="{{ $whatsappUrl }}" target="_blank" rel="noopener">{{ __('store.buttons.whatsapp') }}</a>
            </div>
        </div>
    </section>
@endsection
