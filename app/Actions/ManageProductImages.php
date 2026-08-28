<?php

namespace App\Actions;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class ManageProductImages
{
    /**
     * @param  list<string>  $urls
     * @param  list<UploadedFile>  $uploadedImages
     */
    public function add(Product $product, array $urls, array $uploadedImages): void
    {
        $storedPaths = [];

        try {
            DB::transaction(function () use ($product, $urls, $uploadedImages, &$storedPaths): void {
                $sortOrder = ((int) $product->images()->max('sort_order')) + 1;

                foreach (array_unique($urls) as $url) {
                    if ($product->images()->where('url', $url)->exists()) {
                        continue;
                    }

                    $product->images()->create([
                        'url' => $url,
                        'sort_order' => $sortOrder++,
                    ]);
                }

                foreach ($uploadedImages as $uploadedImage) {
                    $path = $uploadedImage->store("products/{$product->id}", 'public');

                    if (! is_string($path)) {
                        throw new RuntimeException('No fue posible almacenar la imagen del producto.');
                    }

                    $storedPaths[] = $path;
                    $product->images()->create([
                        'path' => $path,
                        'sort_order' => $sortOrder++,
                    ]);
                }
            });
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($storedPaths);

            throw $exception;
        }
    }

    /**
     * @param  list<int>  $imageIds
     */
    public function remove(Product $product, array $imageIds): void
    {
        $images = $product->images()->whereKey($imageIds)->get();
        $paths = $images->pluck('path')->filter()->all();
        $removedUrls = $images->pluck('url')->filter()->all();

        $product->images()->whereKey($images->modelKeys())->delete();

        if ($product->image_url !== null && in_array($product->image_url, $removedUrls, true)) {
            $product->update(['image_url' => null]);
        }

        if ($paths !== []) {
            Storage::disk('public')->delete($paths);
        }
    }

    public function removeAll(Product $product): void
    {
        $this->remove($product, $product->images()->pluck('id')->all());
    }
}
