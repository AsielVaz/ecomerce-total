<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
            'image_urls' => [
                'https://images.example.com/nimbus-front.jpg',
                'https://images.example.com/nimbus-side.jpg',
            ],
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
        $this->assertDatabaseHas('product_images', ['url' => 'https://images.example.com/nimbus-front.jpg']);
        $this->assertDatabaseHas('product_images', ['url' => 'https://images.example.com/nimbus-side.jpg']);
    }

    public function test_admin_can_upload_multiple_product_images(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            ...$this->validProductPayload($category),
            'images' => [
                $this->validPngUpload('front.png'),
                $this->validPngUpload('detail.png'),
            ],
        ]);

        $product = Product::query()->where('sku', 'DTO-GAL-100')->firstOrFail();
        $storedPaths = $product->images()->pluck('path')->all();

        $response->assertRedirect(route('admin.products.index'));
        $this->assertCount(2, $storedPaths);
        Storage::disk('public')->assertExists($storedPaths);
    }

    public function test_non_image_upload_is_rejected_without_creating_product(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), [
                ...$this->validProductPayload($category),
                'images' => [UploadedFile::fake()->create('payload.php', 20, 'application/x-httpd-php')],
            ]);

        $response
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('images.0');
        $this->assertDatabaseMissing('products', ['sku' => 'DTO-GAL-100']);
        Storage::disk('public')->assertEmpty();
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
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $product = Product::factory()->create([
            'name' => 'Original Product',
            'slug' => 'original-product',
            'sku' => 'DTO-ORI-001',
            'image_url' => 'https://images.example.com/original.jpg',
        ]);
        Storage::disk('public')->put('products/original.jpg', 'image-contents');
        $productImage = ProductImage::factory()->for($product)->create([
            'url' => null,
            'path' => 'products/original.jpg',
        ]);
        $legacyImage = ProductImage::factory()->for($product)->create([
            'url' => 'https://images.example.com/original.jpg',
            'path' => null,
            'sort_order' => 1,
        ]);

        $updateResponse = $this->actingAs($admin)->put(route('admin.products.update', $product), [
            'category_id' => $product->category_id,
            'name' => 'Updated Product',
            'sku' => 'DTO-ORI-001',
            'short_description' => $product->short_description,
            'description' => $product->description,
            'price' => 2200,
            'stock' => 4,
            'removed_image_ids' => [$productImage->id, $legacyImage->id],
            'is_active' => false,
            'is_featured' => false,
        ]);

        $updateResponse->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['id' => $product->id, 'slug' => 'updated-product', 'is_active' => false]);
        $this->assertModelMissing($productImage);
        $this->assertModelMissing($legacyImage);
        $this->assertNull($product->fresh()->image_url);
        Storage::disk('public')->assertMissing('products/original.jpg');

        $product->refresh();
        $deleteResponse = $this->delete(route('admin.products.destroy', $product));

        $deleteResponse->assertRedirect(route('admin.products.index'));
        $this->assertModelMissing($product);
    }

    /**
     * @return array<string, mixed>
     */
    private function validProductPayload(Category $category): array
    {
        return [
            'category_id' => $category->id,
            'name' => 'Producto con galería',
            'sku' => 'DTO-GAL-100',
            'short_description' => 'Producto preparado para probar la galería de imágenes.',
            'description' => 'Descripción completa del producto usado durante las pruebas de carga.',
            'price' => 1499,
            'stock' => 12,
            'is_featured' => false,
            'is_active' => true,
        ];
    }

    private function validPngUpload(string $name): UploadedFile
    {
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9Y9Z7xkAAAAASUVORK5CYII=', true);

        $this->assertIsString($png);

        return UploadedFile::fake()->createWithContent($name, $png);
    }
}
