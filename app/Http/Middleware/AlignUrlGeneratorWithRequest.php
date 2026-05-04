<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures generated URLs (e.g. asset(), route()) use the same scheme/host/base
 * as the current HTTP request. Fixes broken /storage links when APP_URL does not
 * match how the site is opened (127.0.0.1 vs localhost, port, subdirectory, etc.).
 */
class AlignUrlGeneratorWithRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        URL::forceRootUrl($request->root());

        return $next($request);
    }
}
