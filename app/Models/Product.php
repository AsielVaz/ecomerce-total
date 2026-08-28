<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'category_id',
    'name',
    'slug',
    'sku',
    'short_description',
    'description',
    'price',
    'compare_at_price',
    'stock',
    'image_url',
    'is_featured',
    'is_active',
])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function primaryImageUrl(): ?string
    {
        return $this->galleryImageUrls()[0] ?? $this->image_url;
    }

    /**
     * @return list<string>
     */
    public function galleryImageUrls(): array
    {
        $images = $this->relationLoaded('images')
            ? $this->images
            : $this->images()->get();

        $urls = $images
            ->map(fn (ProductImage $image): ?string => $image->resolvedUrl())
            ->filter()
            ->unique()
            ->values()
            ->all();

        if ($urls === [] && $this->image_url !== null) {
            return [$this->image_url];
        }

        return $urls;
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_at_price' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
}
