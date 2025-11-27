<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);
        $slug = Str::slug($name);

        return [
            'slug' => $slug,
            'translations' => [
                'name' => [
                    'en' => ucfirst($name),
                    'vi' => ucfirst($name),
                    'ja' => ucfirst($name),
                    'zh' => ucfirst($name),
                ],
            ],
        ];
    }
}
