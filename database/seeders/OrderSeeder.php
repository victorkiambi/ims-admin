<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()
            ->count(10)
            ->create()
            ->each(function ($order) {
                // Dynamically assign 1 to 3 order items to each order
                OrderItem::factory()
                    ->count(rand(1, 3))
                    ->for($order, 'order') // Associate with the current order
                    ->create();
            });

    }
}
