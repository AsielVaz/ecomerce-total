<?php

namespace App\Actions;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\OrderStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CreateOrder
{
    public function handle(User $user, Product $product): Order
    {
        return DB::transaction(function () use ($user, $product): Order {
            $lockedProduct = Product::query()->lockForUpdate()->findOrFail($product->id);

            if (! $lockedProduct->is_active || $lockedProduct->stock < 1) {
                throw ValidationException::withMessages([
                    'product' => 'Este producto ya no se encuentra disponible.',
                ]);
            }

            $lockedProduct->decrement('stock');

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'DTO-'.now()->format('ymd').'-'.Str::upper(Str::random(6)),
                'status' => OrderStatus::Placed,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'subtotal' => $lockedProduct->price,
                'total' => $lockedProduct->price,
                'currency' => 'MXN',
                'placed_at' => now(),
            ]);

            $order->items()->create([
                'product_id' => $lockedProduct->id,
                'product_name' => $lockedProduct->name,
                'sku' => $lockedProduct->sku,
                'unit_price' => $lockedProduct->price,
                'quantity' => 1,
                'line_total' => $lockedProduct->price,
            ]);

            return $order->load('items.product');
        }, 3);
    }
}
