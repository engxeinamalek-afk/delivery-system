<?php
namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()
            ->count(1000)
            ->afterCreating(function (Order $order) {
                OrderItem::factory()
                    ->count(rand(1, 4)) 
                    ->create([
                        'order_id' => $order->id
                    ]);
            })
            ->create();
    }
}
