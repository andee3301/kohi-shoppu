<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    private $targetProducts;

    public function __construct()
    {
        $this->targetProducts = Product::query()->get();
    }

    private function getDummyUsers(int $count): array
    {
        $users = [];

        for ($i = 1; $i <= $count; $i++) {
            $users[] = [
                'full_name' => fake()->name(),
                'phone_number' => fake()->phoneNumber(),
                'email' => fake()->email(),
            ];
        }

        return $users;
    }

    private function getRandomTargetProducts(int $total): array
    {
        return $this->targetProducts->random($total)
            ->map(function ($product) {
                return ['product_id' => $product->id];
            })
            ->toArray();
    }

    /**
     * @throws Exception
     */
    private function createDummyOrder(mixed $user): Order
    {
        $numItems = random_int(1, 5);
        $orderDate = Carbon::today()->subDays(rand(0, 90));

        return Order::factory()
            ->state([
                'created_at' => $orderDate,
                'cart_id' => Cart::factory()
                    ->has(
                        CartItem::factory()->count($numItems)
                            ->state(new Sequence(
                                ...$this->getRandomTargetProducts($numItems)
                            )),
                        'items'
                    ),
                ...$user,
            ])
            ->create();
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $users = $this->getDummyUsers(50);

        foreach ($users as $user) {
            $numOrder = random_int(1, 20);

            for ($j = 1; $j <= $numOrder; $j++) {
                $this->createDummyOrder($user);
            }
        }
    }
}
