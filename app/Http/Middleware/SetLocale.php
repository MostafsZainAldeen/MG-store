<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const SUPPORTED = ['ar', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale');

        if (! is_string($locale) || ! in_array($locale, self::SUPPORTED, true)) {
            $cookie = $request->cookie('locale');
            if (is_string($cookie) && in_array($cookie, self::SUPPORTED, true)) {
                $locale = $cookie;
                $request->session()->put('locale', $locale);
            } else {
                $locale = config('app.locale', 'ar');
                $request->session()->put('locale', $locale);
            }
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
