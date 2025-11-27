<?php

namespace App\Livewire\Checkout;

use App\Events\BrowserEvent;
use App\Events\LivewireEvent;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AddCartItemPopup extends Component
{
    public const MIN_QUANTITY = 1;

    public ?Product $product = null;

    public int $quantity = self::MIN_QUANTITY;

    public string $notes = '';

    protected $listeners = [
        LivewireEvent::USER_SELECT_PRODUCT => 'displayAddCartItem',
    ];

    public function displayAddCartItem(CartService $cart, $product_id): void
    {
        $this->product = Product::find($product_id);
        $this->resetFormData();

        $cartItem = $cart->getCartItem($product_id);

        if ($cartItem) {
            $this->quantity = $cartItem->quantity;
            $this->notes = $cartItem->notes;
        }

        $this->dispatch(BrowserEvent::DISPLAY_OFFCANVAS);

        Log::channel('user_actions')->info('User clicked on product', [
            'product_id' => $product_id,
        ]);
    }

    public function increment(): void
    {
        $this->quantity++;
    }

    public function decrement(): void
    {
        if ($this->quantity > self::MIN_QUANTITY) {
            $this->quantity--;
        }
    }

    public function addCartItem(CartService $cart): void
    {
        $cartItem = $this->getCartItemInstance();
        $cart->addCartItem($cartItem);
        $this->dispatch(LivewireEvent::CART_UPDATED_EVENT, $cartItem);
        $this->dispatch(BrowserEvent::CLOSE_OFFCANVAS);

        Log::channel('user_actions')->info('User add product to cart', [
            'cart_item' => $cartItem,
        ]);
    }

    private function resetFormData(): void
    {
        $this->quantity = self::MIN_QUANTITY;
        $this->notes = '';
    }

    private function getCartItemInstance(): array
    {
        return [
            'product_id' => $this->product->id,
            'quantity' => $this->quantity,
            'notes' => $this->notes,
        ];
    }

    public function render(): View
    {
        return view('livewire.checkout.add-cart-item-popup');
    }
}
