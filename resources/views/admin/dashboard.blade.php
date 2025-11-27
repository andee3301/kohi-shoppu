@php use Illuminate\Support\Str; @endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - {{ config('app.name', 'Cafe Shop') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-r from-rose-50 via-white to-emerald-50 text-slate-900">
    <header class="border-b border-slate-200 bg-white/70 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
            <div class="flex items-center gap-6">
                <a href="{{ route('homepage') }}" class="text-2xl font-semibold text-emerald-600">Coffee Shop</a>
                <span class="text-sm font-medium text-slate-600">Admin Dashboard</span>
            </div>
            <a href="{{ route('homepage') }}" class="text-sm font-medium text-slate-700 hover:text-emerald-600">
                {{ __('Back to Shop') }}
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-12">
        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Orders</h1>
            <p class="text-slate-600 mt-2">Manage all customer orders</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Order #</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Customer</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Items</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Total</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Date</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('checkout.invoice', $order) }}"
                                        class="font-medium text-emerald-600 hover:text-emerald-700">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        <p class="font-medium text-slate-900">{{ $order->customer_name }}</p>
                                        <p class="text-slate-500">{{ $order->customer_email }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-slate-900">
                                    {{ number_format($order->total, 0, '.', ',') }} VND
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form method="POST" action="{{ route('dashboard.orders.update-status', $order) }}"
                                        class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-sm rounded-full px-3 py-1 font-medium border-0 cursor-pointer
                                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                                    {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-700' : '' }}
                                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>
                                                Completed</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>
                                                Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('checkout.invoice', $order) }}"
                                        class="text-emerald-600 hover:text-emerald-700 font-medium">
                                        View Invoice
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                    No orders yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($orders->hasPages())
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </main>
</body>

</html>