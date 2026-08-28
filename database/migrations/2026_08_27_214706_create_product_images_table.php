<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->text('url')->nullable();
            $table->string('path')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['product_id', 'sort_order']);
        });

        DB::table('products')
            ->whereNotNull('image_url')
            ->where('image_url', '!=', '')
            ->orderBy('id')
            ->chunkById(100, function ($products): void {
                $now = now();

                DB::table('product_images')->insert($products->map(fn ($product): array => [
                    'product_id' => $product->id,
                    'url' => $product->image_url,
                    'path' => null,
                    'sort_order' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ])->all());
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
