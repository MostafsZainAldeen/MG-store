@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
    <h1 class="font-display text-3xl text-white">Settings</h1>
    <form action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data" class="mt-8 max-w-3xl space-y-5">
        @csrf
        @method('PUT')

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="mg-label">Store phone</label>
                <input class="mg-input" name="store_phone" value="{{ old('store_phone', $settings['store_phone']) }}">
            </div>
            <div>
                <label class="mg-label">WhatsApp number (digits)</label>
                <input class="mg-input" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number']) }}">
            </div>
        </div>

        <div>
            <label class="mg-label">Address (AR)</label>
            <textarea class="mg-input min-h-[80px]" name="address_ar">{{ old('address_ar', $settings['address_ar']) }}</textarea>
        </div>
        <div>
            <label class="mg-label">Address (EN)</label>
            <textarea class="mg-input min-h-[80px]" name="address_en">{{ old('address_en', $settings['address_en']) }}</textarea>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div>
                <label class="mg-label">Facebook</label>
                <input class="mg-input" name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook']) }}">
            </div>
            <div>
                <label class="mg-label">Instagram</label>
                <input class="mg-input" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram']) }}">
            </div>
            <div>
                <label class="mg-label">X / Twitter</label>
                <input class="mg-input" name="social_twitter" value="{{ old('social_twitter', $settings['social_twitter']) }}">
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="mg-label">Currency code</label>
                <input class="mg-input" name="currency_code" value="{{ old('currency_code', $settings['currency_code']) }}" required>
            </div>
            <div>
                <label class="mg-label">Currency symbol</label>
                <input class="mg-input" name="currency_symbol" value="{{ old('currency_symbol', $settings['currency_symbol']) }}">
            </div>
        </div>

        <div>
            <label class="mg-label">Meta title</label>
            <input class="mg-input" name="meta_title" value="{{ old('meta_title', $settings['meta_title']) }}">
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="mg-label">Meta description (AR)</label>
                <textarea class="mg-input min-h-[90px]" name="meta_description_ar">{{ old('meta_description_ar', $settings['meta_description_ar']) }}</textarea>
            </div>
            <div>
                <label class="mg-label">Meta description (EN)</label>
                <textarea class="mg-input min-h-[90px]" name="meta_description_en">{{ old('meta_description_en', $settings['meta_description_en']) }}</textarea>
            </div>
        </div>

        <div>
            <label class="mg-label">Logo</label>
            <input class="mg-input" type="file" name="logo" accept="image/*">
            @if (!empty($settings['logo_path']))
                <img src="{{ asset('storage/'.$settings['logo_path']) }}" class="mt-3 h-10" alt="">
            @endif
        </div>

        @php $slides = old('hero_slides', $settings['hero_slides'] ?? []); @endphp
        <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6">
            <h2 class="text-lg text-white">Hero slides</h2>
            @for ($i = 0; $i < 3; $i++)
                @php $s = $slides[$i] ?? []; @endphp
                <div class="mt-6 grid gap-3 border-t border-white/10 pt-6 first:mt-4 first:border-t-0 first:pt-0">
                    <p class="text-xs uppercase tracking-widest text-white/45">Slide {{ $i + 1 }}</p>
                    <div class="grid gap-3 md:grid-cols-2">
                        <input class="mg-input" type="text" name="hero_slides[{{ $i }}][title_ar]" value="{{ $s['title_ar'] ?? '' }}" placeholder="Title AR">
                        <input class="mg-input" type="text" name="hero_slides[{{ $i }}][title_en]" value="{{ $s['title_en'] ?? '' }}" placeholder="Title EN">
                    </div>
                    <div class="grid gap-3 md:grid-cols-2">
                        <input class="mg-input" type="text" name="hero_slides[{{ $i }}][subtitle_ar]" value="{{ $s['subtitle_ar'] ?? '' }}" placeholder="Subtitle AR">
                        <input class="mg-input" type="text" name="hero_slides[{{ $i }}][subtitle_en]" value="{{ $s['subtitle_en'] ?? '' }}" placeholder="Subtitle EN">
                    </div>
                </div>
            @endfor
        </div>

        <button class="mg-btn-primary" type="submit">Save settings</button>
    </form>
@endsection
