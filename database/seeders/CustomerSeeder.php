<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use Database\Factories\CustomerFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Customer::factory()
            ->count(10)
            ->create()
            ->each(function ($customer) {
                // Create 1–3 orders for each customer
                Order::factory()
                    ->count(rand(1, 3))
                    ->for($customer, 'customer') // Associate the orders with the current customer
                    ->create();
            });
    }
}
