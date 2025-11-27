<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CheckoutController extends Controller
{
    public function index(CartService $cart): RedirectResponse|View
    {
        $cartInstance = $cart->getCart();

        if ($cartInstance->items->isEmpty()) {
            return redirect()->route('homepage')->with('status', __('shop.cart_empty'));
        }

        return view('checkout.index', [
            'cart' => $cartInstance,
        ]);
    }

    public function store(Request $request, CartService $cart): RedirectResponse
    {
        $cartInstance = $cart->getCart();

        if ($cartInstance->items->isEmpty()) {
            return redirect()->route('homepage')->with('status', __('shop.cart_empty'));
        }

        $validated = $request->validate([
            'full_name' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'email' => ['required', 'email'],
            'shipping_address' => ['required', 'string'],
            'coupon_code' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $order = $cartInstance->order()->save(
            Order::factory()->make(array_merge($validated, [
                'user_id' => optional($request->user())->id,
                'cart_id' => null,
                'status' => 'pending',
            ]))
        );

        OrderCreated::dispatch($order);

        return redirect(URL::signedRoute('orders.complete', ['order' => $order->id]));
    }

    public function show(Request $request, Order $order): View
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }

        $order->load('cart.items.product');

        return view('checkout.show', compact('order'));
    }

    public function invoice(Request $request, Order $order): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $order->load('cart.items.product');

        return view('checkout.show', compact('order'));
    }
}
