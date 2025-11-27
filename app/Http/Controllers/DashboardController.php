<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->is_admin) {
            $orders = Order::with(['items.product', 'user', 'cart'])
                ->latest()
                ->paginate(20);

            return view('admin.dashboard', compact('orders'));
        }

        $orders = $user->orders()
            ->with(['items.product', 'cart'])
            ->latest()
            ->paginate(10);

        return view('dashboard', compact('orders'));
    }

    public function updateStatus(Order $order, Request $request): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        abort_unless($request->user()?->is_admin, 403);

        $order->update(['status' => $request->status]);

        return back()->with('status', 'Order status updated successfully!');
    }
}
