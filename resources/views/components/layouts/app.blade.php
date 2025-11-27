@php use App\Models\Category;
use Illuminate\Support\Str; @endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Cafe Shop') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-r from-rose-50 via-white to-emerald-50 text-slate-900">
    <header class="border-b border-slate-200 bg-white/70 backdrop-blur">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-6 py-5">
            <a href="{{ route('homepage') }}" class="text-2xl font-semibold text-emerald-600">Coffee Shop</a>
            <nav class="flex flex-wrap items-center gap-6 text-sm font-medium text-slate-700">
                @foreach (Category::orderBy('id')->get() as $category)
                    <a href="{{ route('homepage') }}#section-{{ Str::slug($category->slug) }}"
                        class="hover:text-emerald-600">
                        {{ $category->name }}
                    </a>
                @endforeach
                <a href="{{ route('cart.index') }}"
                    class="relative inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-emerald-700 hover:bg-emerald-200">
                    <span aria-hidden="true">🛒</span>
                    <span>{{ __('shop.cart') }}</span>
                    <span class="ml-1 rounded-full bg-white px-2 py-0.5 text-xs text-emerald-600">
                        {{ collect(session('cart.items', []))->sum() }}
                    </span>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-slate-700 hover:bg-slate-200">
                        <span aria-hidden="true">{{ auth()->user()->is_admin ? '⚙️' : '📦' }}</span>
                        <span>{{ auth()->user()->is_admin ? 'Admin' : __('My Orders') }}</span>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-slate-700 hover:bg-slate-200">
                        <span aria-hidden="true">🔐</span>
                        <span>{{ __('Log in') }}</span>
                    </a>
                @endauth
            </nav>
            <x-language-switcher />
        </div>
    </header>
    <main class="mx-auto max-w-6xl px-6 py-12">
        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('status') }}
            </div>
        @endif
        {{ $slot }}
    </main>
    <footer class="border-t border-slate-200 bg-white/70">
        <div class="mx-auto max-w-6xl px-6 py-6 text-center text-sm text-slate-500">
            {{ __('shop.footer') }}
        </div>
    </footer>
</body>

</html>
