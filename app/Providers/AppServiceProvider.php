<?php

namespace App\Providers;

use App\Models\Setting;
use App\Services\CartService;
use App\Services\WishlistService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $view->with([
                'siteLogo' => Setting::get('logo_path'),
                'sitePhone' => Setting::get('store_phone'),
                'whatsappNumber' => Setting::get('whatsapp_number', '966500000000'),
                'addressAr' => Setting::get('address_ar'),
                'addressEn' => Setting::get('address_en'),
                'socialFacebook' => Setting::get('social_facebook'),
                'socialInstagram' => Setting::get('social_instagram'),
                'socialTwitter' => Setting::get('social_twitter'),
                'currencyCode' => Setting::get('currency_code', 'ILS'),
                'currencySymbol' => Setting::get('currency_symbol', '₪'),
                'metaTitle' => Setting::get('meta_title', config('app.name')),
                'metaDescriptionAr' => Setting::get('meta_description_ar'),
                'metaDescriptionEn' => Setting::get('meta_description_en'),
                'cartCount' => app(CartService::class)->count(),
                'wishlistCount' => app(WishlistService::class)->count(),
            ]);
        });
    }
}
