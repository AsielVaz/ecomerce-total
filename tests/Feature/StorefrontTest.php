<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_storefront_renders_active_products_and_hides_inactive_products(): void
    {
        $activeProduct = Product::factory()->create(['name' => 'Visible Nimbus', 'slug' => 'visible-nimbus']);
        $inactiveProduct = Product::factory()->inactive()->create(['name' => 'Hidden Nimbus', 'slug' => 'hidden-nimbus']);

        $response = $this->get(route('home'));

        $response
            ->assertOk()
            ->assertSee($activeProduct->name)
            ->assertDontSee($inactiveProduct->name);
    }

    public function test_category_and_search_filters_return_matching_products(): void
    {
        $technology = Category::factory()->create(['name' => 'Tecnología', 'slug' => 'tecnologia']);
        $home = Category::factory()->create(['name' => 'Hogar', 'slug' => 'hogar']);
        $matchingProduct = Product::factory()->for($technology)->create([
            'name' => 'Audífonos Cósmicos',
            'slug' => 'audifonos-cosmicos',
        ]);
        $otherProduct = Product::factory()->for($home)->create([
            'name' => 'Mesa Serena',
            'slug' => 'mesa-serena',
        ]);

        $response = $this->get(route('home', ['category' => 'tecnologia', 'search' => 'Cósmicos']));

        $response
            ->assertOk()
            ->assertSee($matchingProduct->name)
            ->assertDontSee($otherProduct->name);
    }

    public function test_product_detail_uses_product_specific_social_metadata(): void
    {
        $product = Product::factory()->create([
            'name' => 'Pulse Test',
            'slug' => 'pulse-test',
            'short_description' => 'Descripción social específica.',
            'image_url' => 'https://images.example.com/pulse-test.jpg',
        ]);

        $response = $this->get(route('products.show', $product));

        $response
            ->assertOk()
            ->assertSee('Pulse Test · DTOUCHO')
            ->assertSee('Descripción social específica.')
            ->assertSee('https://images.example.com/pulse-test.jpg', false);
    }

    public function test_product_detail_renders_all_gallery_images_in_carousel(): void
    {
        $product = Product::factory()->create([
            'name' => 'Galería Test',
            'slug' => 'galeria-test',
            'image_url' => null,
        ]);
        ProductImage::factory()->for($product)->create([
            'url' => 'https://images.example.com/gallery-front.jpg',
            'sort_order' => 0,
        ]);
        ProductImage::factory()->for($product)->create([
            'url' => 'https://images.example.com/gallery-side.jpg',
            'sort_order' => 1,
        ]);

        $response = $this->get(route('products.show', $product));

        $response
            ->assertOk()
            ->assertSee('data-carousel', false)
            ->assertSee('https://images.example.com/gallery-front.jpg', false)
            ->assertSee('https://images.example.com/gallery-side.jpg', false)
            ->assertSee('data-carousel-next', false);
    }
}
