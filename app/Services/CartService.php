<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;

class CartService
{
    public function addCartItem(array $item): bool
    {
        $cart = $this->getCart();

        $queryCondition = [
            'cart_id' => $cart->id,
            'product_id' => $item['product_id'],
        ];

        CartItem::updateOrCreate($queryCondition, array_merge($item, [
            'cart_id' => $cart->id,
        ]));

        return true;
    }

    public function removeCartItem($productId): bool
    {
        $cartItem = $this->getCartItem($productId);

        if ($cartItem) {
            $cartItem->forceDelete();

            return true;
        }

        return false;
    }

    public function getCartItem($productId): ?CartItem
    {
        $cart = $this->getCart();

        return $cart->items()->where('product_id', $productId)->first();
    }

    public function getCart(): Cart
    {
        $userId = UserService::getUserIdFromSession();

        $cart = Cart::query()->with('items.product')
            ->where('user_id', $userId)
            ->doesntHave('order')
            ->first();

        if (! $cart) {
            $cart = Cart::factory()->create([
                'user_id' => $userId,
            ]);
        }

        return $cart;
    }

    public function clearCart(): void
    {
        $cart = $this->getCart();
        $cart->items()->delete();
    }
}
