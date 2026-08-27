<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_number' => 'DTO-'.now()->format('ymd').'-'.Str::upper(Str::random(6)),
            'status' => OrderStatus::Placed,
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'subtotal' => 1299.00,
            'total' => 1299.00,
            'currency' => 'MXN',
            'placed_at' => now(),
        ];
    }
}
