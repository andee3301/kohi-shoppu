<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function index(CartService $cart): View
    {
        $cartInstance = $cart->getCart()->load('items.product');

        return view('cart.index', [
            'cart' => $cartInstance,
        ]);
    }

    public function add(Request $request, CartService $cart): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['sometimes', 'integer', 'min:1', 'max:10'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $productId = (int) $validated['product_id'];
        $quantity = (int) ($validated['quantity'] ?? 1);
        $notes = $validated['notes'] ?? '';

        $existingItem = $cart->getCartItem($productId);

        $cart->addCartItem([
            'product_id' => $productId,
            'quantity' => ($existingItem?->quantity ?? 0) + $quantity,
            'notes' => $existingItem?->notes ?? $notes,
        ]);

        return Redirect::back()->with('status', __('shop.added_to_cart'));
    }

    public function update(Request $request, Product $product, CartService $cart): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $cartItem = $cart->getCartItem($product->id);

        $cart->addCartItem([
            'product_id' => $product->id,
            'quantity' => (int) $validated['quantity'],
            'notes' => $cartItem?->notes ?? '',
        ]);

        return Redirect::route('cart.index')->with('status', __('shop.cart_updated'));
    }

    public function remove(Product $product, CartService $cart): RedirectResponse
    {
        $cart->removeCartItem($product->id);

        return Redirect::route('cart.index')->with('status', __('shop.removed_from_cart'));
    }

    public function clear(CartService $cart): RedirectResponse
    {
        $cart->clearCart();

        return Redirect::route('cart.index')->with('status', __('shop.cart_cleared'));
    }
}
