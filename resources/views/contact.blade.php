@extends('layouts.app')

@section('title', __('store.contact.title'))

@section('content')
    <section class="py-14">
        <div class="mg-container grid gap-12 lg:grid-cols-2">
            <div>
                <h1 class="font-display text-4xl text-white">{{ __('store.contact.title') }}</h1>
                <p class="mt-4 text-white/65">{{ __('store.contact.subtitle') }}</p>
                <div class="mt-10 space-y-4 text-sm text-white/75">
                    <p><span class="text-white/45">{{ __('store.contact.address') }}:</span><br>{{ app()->getLocale() === 'ar' ? ($addressAr ?? '—') : ($addressEn ?? '—') }}</p>
                    @if (!empty($sitePhone))
                        <p><span class="text-white/45">{{ __('store.contact.phone') }}:</span> {{ $sitePhone }}</p>
                    @endif
                    @if (!empty($whatsappNumber))
                        <a class="text-[var(--color-mg-gold)] hover:text-white" href="https://wa.me/{{ preg_replace('/\D+/', '', (string) $whatsappNumber) }}" target="_blank" rel="noopener">WhatsApp</a>
                    @endif
                </div>
            </div>
            <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-8">
                <h2 class="font-display text-2xl text-white">{{ __('store.contact.form_title') }}</h2>
                <form action="{{ route('contact.store') }}" method="post" class="mt-8 space-y-4">
                    @csrf
                    <div>
                        <label class="mg-label">{{ __('Name') }}</label>
                        <input class="mg-input" type="text" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div>
                        <label class="mg-label">Email</label>
                        <input class="mg-input" type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div>
                        <label class="mg-label">{{ __('Message') }}</label>
                        <textarea class="mg-input min-h-[140px]" name="message" required>{{ old('message') }}</textarea>
                    </div>
                    <button class="mg-btn-primary" type="submit">{{ __('store.buttons.send') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
