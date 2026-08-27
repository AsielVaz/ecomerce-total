<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminCatalogTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_can_create_category_and_product(): void
    {
        $admin = User::factory()->admin()->create();

        $categoryResponse = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Audio Premium',
            'description' => 'Tecnología para escuchar mejor.',
            'is_active' => true,
        ]);

        $category = Category::query()->where('slug', 'audio-premium')->firstOrFail();
        $categoryResponse->assertRedirect(route('admin.categories.index'));

        $productResponse = $this->post(route('admin.products.store'), [
            'category_id' => $category->id,
            'name' => 'Nimbus Studio',
            'sku' => 'DTO-AUD-100',
            'short_description' => 'Audio detallado para escuchar todo con claridad.',
            'description' => 'Un producto de prueba con información completa y lista para publicarse.',
            'price' => 1999.00,
            'compare_at_price' => 2499.00,
            'stock' => 10,
            'image_url' => 'https://images.example.com/nimbus.jpg',
            'is_featured' => true,
            'is_active' => true,
        ]);

        $productResponse->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Nimbus Studio',
            'slug' => 'nimbus-studio',
            'sku' => 'DTO-AUD-100',
            'category_id' => $category->id,
            'is_featured' => true,
            'is_active' => true,
        ]);
    }

    public function test_invalid_product_payload_is_rejected_without_creating_product(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->from(route('admin.products.create'))->post(route('admin.products.store'), []);

        $response
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors(['name', 'sku', 'short_description', 'description', 'price', 'stock']);
        $this->assertDatabaseCount('products', 0);
    }

    public function test_admin_can_update_and_delete_product(): void
    {
        $admin = User::factory()->admin()->create();
        $product = Product::factory()->create([
            'name' => 'Original Product',
            'slug' => 'original-product',
            'sku' => 'DTO-ORI-001',
        ]);

        $updateResponse = $this->actingAs($admin)->put(route('admin.products.update', $product), [
            'category_id' => $product->category_id,
            'name' => 'Updated Product',
            'sku' => 'DTO-ORI-001',
            'short_description' => $product->short_description,
            'description' => $product->description,
            'price' => 2200,
            'stock' => 4,
            'is_active' => false,
            'is_featured' => false,
        ]);

        $updateResponse->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['id' => $product->id, 'slug' => 'updated-product', 'is_active' => false]);

        $product->refresh();
        $deleteResponse = $this->delete(route('admin.products.destroy', $product));

        $deleteResponse->assertRedirect(route('admin.products.index'));
        $this->assertModelMissing($product);
    }
}
