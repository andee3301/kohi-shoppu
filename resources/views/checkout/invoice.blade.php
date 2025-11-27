<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #{{ $order->order_number }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-r from-rose-50 via-white to-emerald-50">
    <div class="max-w-4xl mx-auto px-6 py-12">
        <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-lg p-8">
            <!-- Header -->
            <div class="flex justify-between items-start mb-8 pb-6 border-b-2 border-slate-200">
                <div>
                    <h1 class="text-3xl font-bold text-emerald-600 mb-2">Coffee Shop</h1>
                    <p class="text-slate-600">{{ __('Invoice') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-slate-900 mb-1">#{{ $order->order_number }}</p>
                    <p class="text-sm text-slate-600">{{ $order->created_at->format('F d, Y') }}</p>
                    <p class="text-sm text-slate-600">{{ $order->created_at->format('h:i A') }}</p>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="mb-8 pb-6 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900 mb-3">{{ __('Customer Information') }}</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-slate-700">{{ __('Name') }}</p>
                        <p class="text-slate-900">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-700">{{ __('Email') }}</p>
                        <p class="text-slate-900">{{ $order->customer_email }}</p>
                    </div>
                    @if($order->customer_phone)
                        <div>
                            <p class="text-sm font-medium text-slate-700">{{ __('Phone') }}</p>
                            <p class="text-slate-900">{{ $order->customer_phone }}</p>
                        </div>
                    @endif
                    @if($order->customer_address)
                        <div>
                            <p class="text-sm font-medium text-slate-700">{{ __('Address') }}</p>
                            <p class="text-slate-900">{{ $order->customer_address }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">{{ __('Order Items') }}</h2>
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-3 text-sm font-semibold text-slate-700">{{ __('Item') }}</th>
                            <th class="text-center py-3 text-sm font-semibold text-slate-700">{{ __('Price') }}</th>
                            <th class="text-center py-3 text-sm font-semibold text-slate-700">{{ __('Qty') }}</th>
                            <th class="text-right py-3 text-sm font-semibold text-slate-700">{{ __('Subtotal') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr class="border-b border-slate-100">
                                <td class="py-4 text-slate-900">{{ $item->product_name }}</td>
                                <td class="py-4 text-center text-slate-700">{{ number_format($item->price, 0, '.', ',') }}
                                    VND</td>
                                <td class="py-4 text-center text-slate-700">{{ $item->quantity }}</td>
                                <td class="py-4 text-right font-medium text-slate-900">
                                    {{ number_format($item->subtotal, 0, '.', ',') }} VND
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Total -->
            <div class="flex justify-end mb-8">
                <div class="w-64">
                    <div class="flex justify-between items-center py-4 border-t-2 border-slate-200">
                        <span class="text-xl font-bold text-slate-900">{{ __('Total') }}</span>
                        <span
                            class="text-2xl font-bold text-emerald-600">{{ number_format($order->total, 0, '.', ',') }}
                            VND</span>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-6">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full
                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                    <span class="text-sm font-medium">{{ __('Status') }}: {{ ucfirst($order->status) }}</span>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="pt-6 border-t border-slate-200">
                <p class="text-sm text-slate-600 text-center">{{ __('Thank you for your order!') }}</p>
                <p class="text-sm text-slate-500 text-center mt-1">
                    {{ __('If you have any questions, please contact us.') }}
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 mt-8 no-print">
                <a href="{{ route('homepage') }}"
                    class="flex-1 text-center px-6 py-3 border border-slate-300 rounded-full font-medium text-slate-700 hover:bg-slate-50 transition">
                    {{ __('Continue Shopping') }}
                </a>
                <button onclick="window.print()"
                    class="flex-1 px-6 py-3 bg-emerald-500 text-white rounded-full font-medium hover:bg-emerald-600 transition">
                    {{ __('Print Invoice') }}
                </button>
            </div>
        </div>
    </div>
</body>

</html>