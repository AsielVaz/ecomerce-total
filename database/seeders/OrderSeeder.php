<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = User::query()->where('email', 'cliente@dtoucho.mx')->firstOrFail();
        $product = Product::query()->where('sku', 'DTO-TEC-001')->firstOrFail();

        $order = Order::query()->updateOrCreate(
            ['order_number' => 'DTO-DEMO-001'],
            [
                'user_id' => $customer->id,
                'status' => OrderStatus::Processing,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'subtotal' => $product->price,
                'total' => $product->price,
                'currency' => 'MXN',
                'placed_at' => now()->subDays(2),
            ],
        );

        $order->items()->updateOrCreate(
            ['sku' => $product->sku],
            [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_price' => $product->price,
                'quantity' => 1,
                'line_total' => $product->price,
            ],
        );
    }
}
