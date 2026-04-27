<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $settings = [
            'store_phone' => Setting::get('store_phone', ''),
            'whatsapp_number' => Setting::get('whatsapp_number', '966500000000'),
            'address_ar' => Setting::get('address_ar', ''),
            'address_en' => Setting::get('address_en', ''),
            'social_facebook' => Setting::get('social_facebook', ''),
            'social_instagram' => Setting::get('social_instagram', ''),
            'social_twitter' => Setting::get('social_twitter', ''),
            'currency_code' => Setting::get('currency_code', 'SAR'),
            'currency_symbol' => Setting::get('currency_symbol', 'ر.س'),
            'meta_title' => Setting::get('meta_title', 'MG Store'),
            'meta_description_ar' => Setting::get('meta_description_ar', ''),
            'meta_description_en' => Setting::get('meta_description_en', ''),
            'logo_path' => Setting::get('logo_path', ''),
            'hero_slides' => Setting::getJson('hero_slides', [
                [
                    'title_ar' => 'منتجاتنا تعكس أناقتك',
                    'title_en' => 'Our products reflect your elegance',
                    'subtitle_ar' => 'منتجات مختارة من أرقى الماركات العالمية.',
                    'subtitle_en' => 'Handpicked products from the world’s finest brands — a refined shopping experience.',
                ],
            ]),
        ];

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'store_phone' => ['nullable', 'string', 'max:64'],
            'whatsapp_number' => ['nullable', 'string', 'max:64'],
            'address_ar' => ['nullable', 'string', 'max:2000'],
            'address_en' => ['nullable', 'string', 'max:2000'],
            'social_facebook' => ['nullable', 'string', 'max:500'],
            'social_instagram' => ['nullable', 'string', 'max:500'],
            'social_twitter' => ['nullable', 'string', 'max:500'],
            'currency_code' => ['required', 'string', 'max:8'],
            'currency_symbol' => ['nullable', 'string', 'max:8'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description_ar' => ['nullable', 'string', 'max:2000'],
            'meta_description_en' => ['nullable', 'string', 'max:2000'],
            'logo' => ['nullable', 'image', 'max:4096'],
            'hero_slides' => ['nullable', 'array'],
            'hero_slides.*.title_ar' => ['nullable', 'string', 'max:255'],
            'hero_slides.*.title_en' => ['nullable', 'string', 'max:255'],
            'hero_slides.*.subtitle_ar' => ['nullable', 'string', 'max:500'],
            'hero_slides.*.subtitle_en' => ['nullable', 'string', 'max:500'],
        ]);

        foreach ([
            'store_phone',
            'whatsapp_number',
            'address_ar',
            'address_en',
            'social_facebook',
            'social_instagram',
            'social_twitter',
            'currency_code',
            'currency_symbol',
            'meta_title',
            'meta_description_ar',
            'meta_description_en',
        ] as $key) {
            Setting::set($key, (string) ($data[$key] ?? ''));
        }

        if ($request->hasFile('logo')) {
            $old = Setting::get('logo_path');
            if (is_string($old) && $old !== '') {
                Storage::disk('public')->delete($old);
            }
            Setting::set('logo_path', $request->file('logo')->store('settings', 'public'));
        }

        $slides = collect($data['hero_slides'] ?? [])
            ->filter(fn ($row) => is_array($row))
            ->values()
            ->all();
        Setting::set('hero_slides', $slides !== [] ? json_encode($slides, JSON_UNESCAPED_UNICODE) : '[]');

        return back()->with('success', __('Saved.'));
    }
}
