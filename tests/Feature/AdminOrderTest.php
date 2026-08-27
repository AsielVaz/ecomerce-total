<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use App\OrderStatus;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminOrderTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_can_update_order_status(): void
    {
        $admin = User::factory()->admin()->create();
        $order = Order::factory()->create(['status' => OrderStatus::Placed]);

        $response = $this->actingAs($admin)->patch(route('admin.orders.update', $order), [
            'status' => OrderStatus::Shipped->value,
        ]);

        $response
            ->assertRedirect(route('admin.orders.show', $order))
            ->assertSessionHas('success');
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => OrderStatus::Shipped->value,
        ]);
    }

    public function test_invalid_order_status_is_rejected(): void
    {
        $admin = User::factory()->admin()->create();
        $order = Order::factory()->create(['status' => OrderStatus::Placed]);

        $response = $this->actingAs($admin)->from(route('admin.orders.show', $order))->patch(route('admin.orders.update', $order), [
            'status' => 'invented-status',
        ]);

        $response
            ->assertRedirect(route('admin.orders.show', $order))
            ->assertSessionHasErrors('status');
        $this->assertSame(OrderStatus::Placed, $order->fresh()->status);
    }
}
