<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_shop_page_displays_translated_categories_and_products(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Bakery & Treats')
            ->assertSee('Butter Croissant')
            ->assertSee('Cold Brew Concentrate');
    }

    public function test_cart_page_is_accessible(): void
    {
        $response = $this->get('/cart');

        $response
            ->assertOk()
            ->assertSee(__('shop.cart_empty'));
    }
}
