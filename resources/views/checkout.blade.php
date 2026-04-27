@extends('layouts.app')

@section('title', __('store.checkout.title'))

@section('content')
    <section class="py-14">
        <div class="mg-container grid gap-12 lg:grid-cols-[1fr_380px]">
            <div>
                <h1 class="font-display text-4xl text-white">{{ __('store.checkout.title') }}</h1>
                <p class="mt-3 text-sm text-white/55">{{ __('store.checkout.guest') }}</p>

                <form action="{{ route('checkout.store') }}" method="post" class="mt-10 space-y-5">
                    @csrf
                    <div>
                        <label class="mg-label">{{ __('fields.full_name') }}</label>
                        <input class="mg-input" type="text" name="full_name" value="{{ old('full_name') }}" required>
                        @error('full_name')<p class="mt-2 text-xs text-red-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mg-label">{{ __('fields.phone') }}</label>
                        <input class="mg-input" type="tel" name="phone" value="{{ old('phone') }}" required>
                        @error('phone')<p class="mt-2 text-xs text-red-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mg-label">{{ __('fields.address') }}</label>
                        <textarea class="mg-input min-h-[100px]" name="address" required>{{ old('address') }}</textarea>
                        @error('address')<p class="mt-2 text-xs text-red-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mg-label">{{ __('fields.city') }}</label>
                        <input class="mg-input" type="text" name="city" value="{{ old('city') }}" required>
                        @error('city')<p class="mt-2 text-xs text-red-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mg-label">{{ __('fields.notes') }}</label>
                        <textarea class="mg-input min-h-[90px]" name="notes">{{ old('notes') }}</textarea>
                    </div>
                    <div>
                        <label class="mg-label">{{ __('fields.delivery_details') }}</label>
                        <textarea class="mg-input min-h-[90px]" name="delivery_details">{{ old('delivery_details') }}</textarea>
                    </div>

                    <button class="mg-btn-primary w-full sm:w-auto" type="submit">{{ __('store.buttons.confirm_order') }}</button>
                </form>
            </div>

            <aside class="rounded-3xl border border-white/10 bg-white/[0.03] p-8">
                <h2 class="font-display text-2xl text-white">{{ __('store.checkout.summary') }}</h2>
                <div class="mt-6 space-y-3 text-sm text-white/70">
                    @foreach ($lines as $line)
                        <div class="flex justify-between gap-4">
                            <span>{{ $line['product']->localizedName() }} × {{ $line['quantity'] }}</span>
                            <span>{{ number_format($line['line_total'], 2) }} {{ $currency }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 border-t border-white/10 pt-6 text-sm">
                    <div class="flex justify-between text-white/70">
                        <span>{{ __('store.cart.subtotal') }}</span>
                        <span>{{ number_format($subtotal, 2) }} {{ $currency }}</span>
                    </div>
                    @if ($discount > 0)
                        <div class="mt-3 flex justify-between text-emerald-300">
                            <span>{{ __('store.cart.discount') }}</span>
                            <span>- {{ number_format($discount, 2) }}</span>
                        </div>
                    @endif
                    <div class="mt-6 flex justify-between text-lg text-white">
                        <span>{{ __('store.cart.total') }}</span>
                        <span>{{ number_format($total, 2) }} {{ $currency }}</span>
                    </div>
                </div>
                <p class="mt-6 text-xs uppercase tracking-[0.25em] text-white/45">{{ __('store.checkout.cod') }}</p>
                <a class="mg-btn-outline mt-6 block w-full text-center" href="{{ $whatsappUrl }}" target="_blank" rel="noopener">{{ __('store.buttons.whatsapp') }}</a>
            </aside>
        </div>
    </section>
@endsection
