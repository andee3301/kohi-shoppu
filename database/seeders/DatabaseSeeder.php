<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = collect([
            [
                'key' => 'bakery-and-treats',
                'name' => 'Bakery & Treats',
                'description' => 'Freshly baked pastries and sweet treats.',
            ],
            [
                'key' => 'brews-and-pour-overs',
                'name' => 'Brews & Pour Overs',
                'description' => 'Filter coffees and slow brews.',
            ],
            [
                'key' => 'signature-coffee',
                'name' => 'Signature Coffee',
                'description' => 'House-special espresso drinks.',
            ],
        ])->map(function ($data) {
            return [
                'key' => $data['key'],
                'model' => Category::create([
                    'name' => $data['name'],
                    'description' => $data['description'],
                ]),
            ];
        });

        $products = [
            [
                'name' => 'Butter Croissant',
                'category' => 'bakery-and-treats',
                'price' => 38000,
                'description' => 'Flaky croissant made with cultured butter and layers of dough.',
            ],
            [
                'name' => 'Chocolate Fudge Brownie',
                'category' => 'bakery-and-treats',
                'price' => 42000,
                'description' => 'Decadent brownie baked with dark chocolate and sea salt.',
            ],
            [
                'name' => 'Cinnamon Roll',
                'category' => 'bakery-and-treats',
                'price' => 45000,
                'description' => 'Soft roll swirled with cinnamon sugar and topped with icing.',
            ],
            [
                'name' => 'Cold Brew Concentrate',
                'category' => 'brews-and-pour-overs',
                'price' => 60000,
                'description' => 'Slow steeped for 18 hours for a bold yet smooth cold brew.',
            ],
            [
                'name' => 'Colombian Drip',
                'category' => 'brews-and-pour-overs',
                'price' => 52000,
                'description' => 'Balanced cup featuring cocoa notes and a silky mouthfeel.',
            ],
            [
                'name' => 'Ethiopian Pour Over',
                'category' => 'brews-and-pour-overs',
                'price' => 55000,
                'description' => 'Floral aroma with bright citrus and honey sweetness.',
            ],
            [
                'name' => 'Classic Espresso',
                'category' => 'signature-coffee',
                'price' => 48000,
                'description' => 'Double shot of espresso with caramel notes and a smooth finish.',
            ],
            [
                'name' => 'Iced Caramel Macchiato',
                'category' => 'signature-coffee',
                'price' => 65000,
                'description' => 'Rich espresso layered over milk, vanilla, and caramel drizzle.',
            ],
            [
                'name' => 'Vanilla Latte',
                'category' => 'signature-coffee',
                'price' => 62000,
                'description' => 'Velvety steamed milk infused with Madagascar vanilla and espresso.',
            ],
        ];

        $categoriesByKey = $categories->keyBy('key');

        foreach ($products as $product) {
            Product::create([
                'category_id' => $categoriesByKey[$product['category']]['model']->id,
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'currency' => 'VND',
                'display_image_url' => null,
            ]);
        }

        User::factory()->create([
            'name' => 'Demo Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret123'),
            'is_admin' => true,
        ]);
    }
}
