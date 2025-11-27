<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <p class="text-sm text-slate-600">
            {{ __('Track the progress of your recent purchases here.') }}
        </p>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <th class="px-4 py-3">{{ __('Order #') }}</th>
                        <th class="px-4 py-3">{{ __('Placed On') }}</th>
                        <th class="px-4 py-3">{{ __('Items') }}</th>
                        <th class="px-4 py-3">{{ __('Status') }}</th>
                        <th class="px-4 py-3 text-right">{{ __('Total') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-4 py-3 font-semibold text-slate-900">
                                {{ $order->order_number }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <ul class="list-disc space-y-1 pl-5 text-xs text-slate-500">
                                    @foreach ($order->items as $item)
                                        <li>{{ $item->product->name }} × {{ $item->quantity }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right font-semibold">
                                ${{ number_format($order->total, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">
                                {{ __('You have no orders yet. Explore the menu and place your first order!') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $orders->links() }}
    </div>
</x-app-layout>