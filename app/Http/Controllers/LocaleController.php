<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'locale' => ['required', 'string', 'in:' . implode(',', Config::get('app.supported_locales', ['en']))],
        ]);

        Session::put('locale', $validated['locale']);
        App::setLocale($validated['locale']);

        return Redirect::back();
    }

    public function switch(string $locale): RedirectResponse
    {
        $supportedLocales = Config::get('app.supported_locales', ['en']);
        
        if (!in_array($locale, $supportedLocales)) {
            abort(404);
        }

        Session::put('locale', $locale);
        App::setLocale($locale);

        return Redirect::back();
    }
}
