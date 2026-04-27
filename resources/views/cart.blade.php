@extends('layouts.app')

@section('title', __('store.cart.title'))

@section('content')
    <section class="py-14">
        <div class="mg-container">
            <h1 class="font-display text-4xl text-white">{{ __('store.cart.title') }}</h1>

            @if (empty($lines))
                <p class="mt-8 text-white/60">{{ __('store.cart.empty') }}</p>
                <a class="mg-btn-primary mt-6 inline-flex" href="{{ route('shop') }}">{{ __('store.buttons.continue_shopping') }}</a>
            @else
                <form action="{{ route('cart.update') }}" method="post" class="mt-10 space-y-6">
                    @csrf
                    <div class="space-y-4">
                        @foreach ($lines as $idx => $line)
                            @php $p = $line['product']; @endphp
                            <div class="flex flex-col gap-4 rounded-3xl border border-white/10 bg-white/[0.03] p-6 lg:flex-row lg:items-center lg:justify-between">
                                <div class="flex gap-4">
                                    @if ($p->primaryImage())
                                        <img src="{{ asset('storage/'.$p->primaryImage()->path) }}" alt="" class="h-24 w-24 rounded-2xl object-cover">
                                    @endif
                                    <div>
                                        <a href="{{ route('product.show', $p->slug) }}" class="font-display text-xl text-white hover:text-[var(--color-mg-gold)]">{{ $p->localizedName() }}</a>
                                        <p class="mt-1 text-xs text-white/45">{{ $p->brand?->localizedName() }}</p>
                                        <p class="mt-2 text-sm text-[var(--color-mg-gold)]">{{ number_format($p->currentPrice(), 2) }} × {{ $line['quantity'] }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="items[{{ $idx }}][product_id]" value="{{ $p->id }}">
                                    <input class="mg-input w-24" type="number" name="items[{{ $idx }}][quantity]" value="{{ $line['quantity'] }}" min="0" max="{{ $p->stock }}">
                                    <a class="text-xs text-red-300 hover:text-red-200" href="{{ route('cart.remove', $p->id) }}" onclick="event.preventDefault(); document.getElementById('rm-{{ $p->id }}').submit();">{{ __('store.buttons.remove') }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="mg-btn-outline" type="submit">{{ __('store.buttons.update') }}</button>
                </form>

                @foreach ($lines as $line)
                    <form id="rm-{{ $line['product']->id }}" action="{{ route('cart.remove', $line['product']->id) }}" method="post" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach

                <form action="{{ route('cart.coupon') }}" method="post" class="mt-10 flex flex-wrap items-end gap-3">
                    @csrf
                    <div>
                        <label class="mg-label">{{ __('store.cart.coupon') }}</label>
                        <input class="mg-input" type="text" name="code" value="{{ old('code', app(\App\Services\CartService::class)->couponCode()) }}" placeholder="CODE">
                    </div>
                    <button class="mg-btn-primary" type="submit">{{ __('store.buttons.apply') }}</button>
                </form>

                <div class="mt-12 max-w-md rounded-3xl border border-white/10 bg-black/30 p-8">
                    <div class="flex justify-between text-sm text-white/70">
                        <span>{{ __('store.cart.subtotal') }}</span>
                        <span>{{ number_format($subtotal, 2) }} {{ $currencyCode ?? 'SAR' }}</span>
                    </div>
                    @if (($discount ?? 0) > 0)
                        <div class="mt-3 flex justify-between text-sm text-emerald-300">
                            <span>{{ __('store.cart.discount') }}</span>
                            <span>- {{ number_format($discount, 2) }} {{ $currencyCode ?? 'SAR' }}</span>
                        </div>
                    @endif
                    <div class="mt-6 flex justify-between border-t border-white/10 pt-6 text-lg text-white">
                        <span>{{ __('store.cart.total') }}</span>
                        <span>{{ number_format($total, 2) }} {{ $currencyCode ?? 'SAR' }}</span>
                    </div>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a class="mg-btn-primary flex-1 text-center" href="{{ route('checkout.index') }}">{{ __('store.checkout.title') }}</a>
                        <a class="mg-btn-outline flex-1 text-center" href="{{ $whatsappUrl }}" target="_blank" rel="noopener">{{ __('store.buttons.whatsapp') }}</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
