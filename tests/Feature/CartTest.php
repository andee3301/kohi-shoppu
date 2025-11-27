<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_user_can_add_product_to_cart(): void
    {
        $product = Product::first();
        $userId = (string) Str::uuid();

        $response = $this->withSession(['user_id' => $userId])
            ->from('/')
            ->post('/cart', [
                'product_id' => $product->id,
                'quantity' => 2,
                'notes' => 'Lab instructions note',
            ]);

        $response->assertRedirect('/');

        $cart = Cart::where('user_id', $userId)->first();
        $this->assertNotNull($cart);

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'notes' => 'Lab instructions note',
        ]);
    }

    public function test_user_can_update_cart_quantity(): void
    {
        $product = Product::first();
        $userId = (string) Str::uuid();
        $cart = Cart::create(['user_id' => $userId]);
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 1,
            'notes' => 'No sugar',
        ]);

        $response = $this->withSession(['user_id' => $userId])
            ->patch('/cart/' . $product->id, [
                'quantity' => 3,
            ]);

        $response->assertRedirect(route('cart.index'));

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 3,
            'notes' => 'No sugar',
        ]);
    }

    public function test_user_can_remove_item_from_cart(): void
    {
        $product = Product::first();
        $userId = (string) Str::uuid();
        $cart = Cart::create(['user_id' => $userId]);
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 1,
            'notes' => 'Less ice',
        ]);

        $response = $this->withSession(['user_id' => $userId])
            ->delete('/cart/' . $product->id);

        $response->assertRedirect(route('cart.index'));

        $this->assertDatabaseMissing('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_user_can_clear_cart(): void
    {
        $userId = (string) Str::uuid();
        $cart = Cart::create(['user_id' => $userId]);
        $products = Product::take(2)->get();
        $cart->items()->createMany([
            [
                'product_id' => $products[0]->id,
                'quantity' => 2,
                'notes' => 'Double shot',
            ],
            [
                'product_id' => $products[1]->id,
                'quantity' => 1,
                'notes' => 'Oat milk',
            ],
        ]);

        $response = $this->withSession(['user_id' => $userId])
            ->delete('/cart');

        $response->assertRedirect(route('cart.index'));

        $this->assertDatabaseMissing('cart_items', [
            'cart_id' => $cart->id,
        ]);
    }
}
