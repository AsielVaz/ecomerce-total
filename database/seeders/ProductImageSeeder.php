<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $additionalImages = [
            'DTO-TEC-001' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?auto=format&fit=crop&w=1200&q=80',
            'DTO-TEC-002' => 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?auto=format&fit=crop&w=1200&q=80',
            'DTO-HOG-001' => 'https://images.unsplash.com/photo-1511081692775-05d0f180a065?auto=format&fit=crop&w=1200&q=80',
            'DTO-MOD-001' => 'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?auto=format&fit=crop&w=1200&q=80',
        ];

        Product::query()->whereNotNull('image_url')->each(function (Product $product) use ($additionalImages): void {
            $product->images()->updateOrCreate(
                ['url' => $product->image_url],
                ['sort_order' => 0],
            );

            if (isset($additionalImages[$product->sku])) {
                $product->images()->updateOrCreate(
                    ['url' => $additionalImages[$product->sku]],
                    ['sort_order' => 1],
                );
            }
        });
    }
}
