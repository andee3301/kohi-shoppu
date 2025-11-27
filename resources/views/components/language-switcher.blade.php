@php
    $supportedLocales = config('app.supported_locales', ['en']);
    $labels = [
        'en' => 'EN',
        'vi' => 'VI',
        'ja' => '日本語',
        'zh' => '中文',
    ];
@endphp
<div class="relative" data-language-menu>
    <button type="button"
        class="flex items-center gap-1 rounded-full border border-slate-200 px-3 py-1 text-sm text-slate-700 hover:border-emerald-400"
        data-language-menu-toggle>
        <span aria-hidden="true">🌐</span>
        <span>{{ strtoupper(app()->getLocale()) }}</span>
    </button>
    <div class="absolute right-0 z-10 mt-2 hidden w-36 rounded-lg border border-slate-200 bg-white p-1 shadow-lg"
        data-language-menu-panel>
        @foreach ($supportedLocales as $locale)
            <form method="POST" action="{{ route('locale.set') }}">
                @csrf
                <input type="hidden" name="locale" value="{{ $locale }}">
                <button type="submit"
                    class="w-full rounded-md px-3 py-2 text-left text-sm hover:bg-emerald-50 {{ app()->getLocale() === $locale ? 'font-semibold text-emerald-600' : 'text-slate-700' }}">
                    {{ $labels[$locale] ?? strtoupper($locale) }}
                </button>
            </form>
        @endforeach
    </div>
</div>