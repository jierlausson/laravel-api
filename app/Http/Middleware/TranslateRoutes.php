<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TranslateRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $availableLangs = ['pt_BR', 'en'];
        $userLangs = preg_split('/,|;/', $request->server('HTTP_ACCEPT_LANGUAGE'));

        foreach ($availableLangs as $lang) {
            if (in_array($lang, $userLangs)) {
                LaravelLocalization::setLocale($lang);
                break;
            }
        }

        return $next($request);
    }
}
