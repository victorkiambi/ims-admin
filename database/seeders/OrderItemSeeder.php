<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::all()->each(function ($order) {
            // Generate a random number of order items (1-5) for each order
            $orderItemCount = rand(1, 5);

            // Create order items for the current order
            $orderItems = OrderItem::factory()
                ->count($orderItemCount)
                ->for($order, 'order')
                ->create();

            // Calculate the total amount of the order
            $totalAmount = $orderItems->sum('price');

            // Update the order's total amount
            $order->update(['total_amount' => $totalAmount]);

            // Ensure consistent payment status based on order status
            if ($order->status === 'completed') {
                $order->update(['payment_status' => 'completed']);
            }
        });    }
}
