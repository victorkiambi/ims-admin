<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
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
            ->count(5)
            ->create()
            ->each(function ($customer) {
                // Create 1–3 orders for each customer
                $orderCount = rand(1, 3);

                for ($i = 0; $i < $orderCount; $i++) {
                    $order = Order::factory()
                        ->for($customer, 'customer')
                        ->create();

                    // Generate a random number of order items (1-5)
                    $orderItemCount = rand(1, 5);

                    // Create order items for the current order
                    $orderItems = OrderItem::factory()
                        ->count($orderItemCount)
                        ->for($order, 'order')
                        ->create();

                    // Calculate the total amount of the order
                    $totalAmount = $orderItems->sum('price');

                    // Update the order's total amount
                    $order->update(['total' => $totalAmount]);

                    // Ensure consistent payment status based on order status
                    if ($order->status === 'completed') {
                        $order->update(['payment_status' => 'completed']);
                    }
                    if ($order->status === 'processing') {
                        $order->update(['payment_status' => 'pending']);
                    }
                }
            });
    }
}
