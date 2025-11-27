<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $supported = Config::get('app.supported_locales', ['en']);
        $locale = Session::get('locale');

        if (! $locale || ! in_array($locale, $supported, true)) {
            $locale = $request->getPreferredLanguage($supported) ?? Config::get('app.locale');
            Session::put('locale', $locale);
        }

        App::setLocale($locale);

        return $next($request);
    }
}
