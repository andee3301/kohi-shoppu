@php use Illuminate\Support\Str; @endphp

<x-layouts.app>
    <section class="mb-12 space-y-4">
        <p class="text-sm uppercase tracking-[0.3em] text-emerald-600">{{ __('shop.tagline') }}</p>
        <h1 class="text-4xl font-semibold text-slate-900 md:text-5xl">{{ __('shop.headline') }}</h1>
        <p class="max-w-2xl text-base text-slate-600">{{ __('shop.subhead') }}</p>
    </section>

    <div class="space-y-16">
        @foreach ($categories as $category)
            <section id="section-{{ Str::slug($category->slug) }}" class="space-y-6">
                <header class="flex items-baseline justify-between">
                    <h2 class="text-2xl font-semibold text-slate-900">{{ $category->name }}</h2>
                    <a href="#top" class="text-sm text-emerald-600 hover:underline">{{ __('shop.back_to_top') }}</a>
                </header>

                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($category->products as $product)
                        <article
                            class="flex h-full flex-col justify-between rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                            <div class="space-y-4">
                                <div class="aspect-video w-full overflow-hidden rounded-xl bg-slate-100">
                                    <img src="{{ $product->image_path ?? 'https://images.unsplash.com/photo-1497515114629-f71d768fd07c?auto=format&fit=crop&w=640&q=80' }}"
                                        alt="{{ $product->name }}" class="h-full w-full object-cover" loading="lazy">
                                </div>
                                <div class="space-y-2">
                                    <h3 class="text-xl font-semibold text-slate-900">{{ $product->name }}</h3>
                                    <p class="text-sm text-slate-600">{{ $product->description }}</p>
                                </div>
                            </div>
                            <div class="mt-6 flex items-center justify-between">
                                <div class="text-lg font-semibold text-slate-900">
                                    {{ number_format($product->price, 0, '.', ',') }} VND
                                </div>
                                <form method="POST" action="{{ route('cart.add') }}" class="flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-600">
                                        <span aria-hidden="true">+</span>
                                        {{ __('shop.add_to_cart') }}
                                    </button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
</x-layouts.app>