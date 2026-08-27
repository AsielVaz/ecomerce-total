<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        $price = fake()->randomFloat(2, 100, 12000);

        return [
            'category_id' => Category::factory(),
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            'sku' => fake()->unique()->bothify('DTO-####-??'),
            'short_description' => fake()->sentence(12),
            'description' => fake()->paragraphs(3, true),
            'price' => $price,
            'compare_at_price' => $price + 500,
            'stock' => fake()->numberBetween(1, 80),
            'image_url' => null,
            'is_featured' => false,
            'is_active' => true,
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes): array => ['is_featured' => true]);
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes): array => ['stock' => 0]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => ['is_active' => false]);
    }
}
