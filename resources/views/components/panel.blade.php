<div {{ $attributes->merge(['class' => 'bg-surface rounded-lg shadow-lg']) }}>
    @isset($header)
        <h1
            class="bg-surface text-2xl text-on-surface-600 border-b border-on-surface p-4 mb-2 flex flex-row items-center justify-between sticky top-0 rounded-t-lg z-10">
            <div class="flex flex-row items-center">
                @includeIf('components/icons/' . ($icon ?? ''))
                <span class="ml-2">{{ $header }}</span>
            </div>

            @isset($action)
                {{ $action }}
            @endisset
        </h1>
    @endisset

    <div class="p-6">
        {{ $slot }}
    </div>
</div>