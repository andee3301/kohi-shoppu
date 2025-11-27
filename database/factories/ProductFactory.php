<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        $slug = Str::slug($name);

        return [
            'category_id' => Category::factory(),
            'slug' => $slug,
            'translations' => [
                'name' => [
                    'en' => ucfirst($name),
                    'vi' => ucfirst($name),
                    'ja' => ucfirst($name),
                    'zh' => ucfirst($name),
                ],
                'description' => [
                    'en' => $this->faker->sentence(12),
                    'vi' => $this->faker->sentence(12),
                    'ja' => $this->faker->sentence(12),
                    'zh' => $this->faker->sentence(12),
                ],
            ],
            'price' => $this->faker->numberBetween(20000, 120000),
            'image_path' => null,
        ];
    }
}
