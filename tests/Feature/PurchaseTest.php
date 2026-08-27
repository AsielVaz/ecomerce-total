<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\OrderStatus;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guest_is_redirected_to_login_when_attempting_to_purchase(): void
    {
        $product = Product::factory()->create(['slug' => 'guest-product']);

        $response = $this->post(route('orders.store', $product));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_authenticated_customer_purchase_creates_order_item_and_decrements_stock(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'slug' => 'atomic-product',
            'price' => 2499.00,
            'stock' => 3,
        ]);

        $response = $this->actingAs($user)->post(route('orders.store', $product));

        $order = Order::query()->firstOrFail();
        $response
            ->assertRedirect(route('orders.show', $order))
            ->assertSessionHas('success');
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status' => OrderStatus::Placed->value,
            'total' => 2499.00,
        ]);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'line_total' => 2499.00,
        ]);
        $this->assertSame(2, $product->fresh()->stock);
    }

    public function test_out_of_stock_product_is_rejected_without_creating_an_order(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->outOfStock()->create(['slug' => 'sold-out-product']);

        $response = $this->actingAs($user)->from(route('products.show', $product))->post(route('orders.store', $product));

        $response
            ->assertRedirect(route('products.show', $product))
            ->assertSessionHasErrors(['product' => 'Este producto ya no se encuentra disponible.']);
        $this->assertDatabaseCount('orders', 0);
        $this->assertSame(0, $product->fresh()->stock);
    }

    public function test_customer_cannot_view_another_customers_order(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $order = Order::factory()->for($owner)->create();

        $response = $this->actingAs($intruder)->get(route('orders.show', $order));

        $response->assertNotFound();
    }
}
