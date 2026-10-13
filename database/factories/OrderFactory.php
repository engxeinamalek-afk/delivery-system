<?php
namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    private static int $orderSequence = 0;

    public function definition(): array
    {
        self::$orderSequence++;

        $createdAt = now()->subMonth()->addMinutes(self::$orderSequence * 43);

        $status = $this->faker->randomElement([OrderStatus::ASSIGNED->value, OrderStatus::DELIVERED->value]); 

        $driverId = User::where('role', 'driver')->inRandomOrder()->first()?->id;

        $deliveredAt = null;
        if ($status === 'delivered') {
            $deliveredAt = (clone $createdAt)->modify('+' . rand(20, 90) . ' minutes');
        }

        return [
            'customer_id'  => User::where('role', 'customer')->inRandomOrder()->first()?->id,
            'store_id'     => Store::inRandomOrder()->first()?->id ?? 1,
            'driver_id'    => $driverId,
            'status'       => $status,
            'created_at'   => $createdAt,
            
            'assigned_at'  => $createdAt,
            'delivered_at' => $deliveredAt,
        ];
    }
}
