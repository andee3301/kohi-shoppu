<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiCategoriesProductsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_list_categories_returns_seeded_categories()
    {
        $response = $this->getJson('/api/v1/categories');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'name',
                    'description',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $this->assertGreaterThanOrEqual(3, count($response->json('data'))); // seeded categories
    }

    public function test_list_products_with_category_relation()
    {
        $response = $this->getJson('/api/v1/products?with=category');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'category_id',
                    'name',
                    'description',
                    'price',
                    'currency',
                    'display_image_url',
                    'created_at',
                    'updated_at',
                    'category' => ['id', 'name', 'description', 'created_at', 'updated_at'],
                ],
            ],
        ]);
    }

    public function test_can_create_product_with_lab_fields()
    {
        $category = Category::first();

        $payload = [
            'name' => 'Test Product',
            'description' => 'A product created by API test.',
            'price' => 12345,
            'currency' => 'VND',
            'display_image_url' => 'https://example.com/image.jpg',
            'category_id' => $category->id,
        ];

        $response = $this->postJson('/api/v1/products', $payload);

        $response->assertCreated();
        $response->assertJsonFragment([
            'name' => 'Test Product',
            'currency' => 'VND',
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'currency' => 'VND',
        ]);
    }
}
