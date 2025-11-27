<x-layouts.app>
    <section class="mb-8 space-y-3">
        <h1 class="text-3xl font-semibold text-slate-900">{{ __('shop.cart_title') }}</h1>
        <p class="text-sm text-slate-600">{{ __('shop.cart_description') }}</p>
    </section>

    @php
        $items = $cart->items;
    @endphp

    @if ($items->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-200 bg-white/70 p-10 text-center">
            <p class="text-base text-slate-600">{{ __('shop.cart_empty') }}</p>
            <a href="{{ route('homepage') }}"
                class="mt-4 inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-600">
                {{ __('shop.continue_shopping') }}
            </a>
        </div>
    @else
        <div class="space-y-6">
            <div class="space-y-4">
                @foreach ($items as $item)
                    <div
                        class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm md:flex-row md:items-center md:justify-between">
                        <div class="space-y-1">
                            <h2 class="text-xl font-semibold text-slate-900">{{ $item->product->name }}</h2>
                            <p class="text-sm text-slate-600">{{ $item->product->description }}</p>
                            <p class="text-sm font-medium text-slate-700">
                                {{ number_format($item->product->price, 0, '.', ',') }} VND
                            </p>
                        </div>
                        <div class="flex flex-col items-end gap-3 md:flex-row md:items-center">
                            <form method="POST" action="{{ route('cart.update', $item->product) }}"
                                class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <label class="text-sm text-slate-600">
                                    {{ __('shop.quantity') }}
                                    <input type="number" name="quantity" min="1" max="10" value="{{ $item->quantity }}"
                                        class="ml-2 w-16 rounded-md border border-slate-200 px-3 py-1 text-sm">
                                </label>
                                <button type="submit"
                                    class="rounded-full border border-slate-300 px-3 py-1 text-sm text-slate-700 hover:border-emerald-400 hover:text-emerald-600">{{ __('shop.update') }}</button>
                            </form>
                            <form method="POST" action="{{ route('cart.remove', $item->product) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="rounded-full border border-red-200 px-3 py-1 text-sm text-red-600 hover:bg-red-50">{{ __('shop.remove') }}</button>
                            </form>
                            <div class="text-lg font-semibold text-slate-900">
                                {{ number_format($item->product->price * $item->quantity, 0, '.', ',') }} VND
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div
                class="flex flex-col items-start gap-4 rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm md:flex-row md:items-center md:justify-between">
                <div class="space-y-1">
                    <p class="text-sm uppercase tracking-widest text-slate-500">{{ __('shop.subtotal') }}</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ number_format($cart->total_amount, 0, '.', ',') }}
                        VND</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <form method="POST" action="{{ route('cart.clear') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="rounded-full border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:border-emerald-400 hover:text-emerald-600">{{ __('shop.clear_cart') }}</button>
                    </form>
                    <a href="{{ route('checkout.index') }}"
                        class="rounded-full bg-emerald-500 px-5 py-2 text-sm font-medium text-white hover:bg-emerald-600">
                        {{ __('shop.checkout') }}
                    </a>
                </div>
            </div>
        </div>
    @endif
</x-layouts.app>