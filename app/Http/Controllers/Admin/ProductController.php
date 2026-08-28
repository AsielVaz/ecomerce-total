<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ManageProductImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('search')->toString());

        $products = Product::query()
            ->with(['category', 'images'])
            ->when($search !== '', fn ($query) => $query->where(fn ($searchQuery) => $searchQuery
                ->where('name', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%")))
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'search'));
    }

    public function create(): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request, ManageProductImages $manageProductImages): RedirectResponse
    {
        $data = $this->productData($request);
        $product = Product::create($data);

        try {
            $manageProductImages->add(
                $product,
                $this->imageUrls($request),
                $request->file('images', []),
            );
        } catch (Throwable $exception) {
            $product->delete();

            throw $exception;
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto creado.');
    }

    public function edit(Product $product): View
    {
        $product->load('images');
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product, ManageProductImages $manageProductImages): RedirectResponse
    {
        $product->update($this->productData($request));

        $manageProductImages->add(
            $product,
            $this->imageUrls($request),
            $request->file('images', []),
        );
        $manageProductImages->remove($product, $request->validated('removed_image_ids', []));

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Product $product, ManageProductImages $manageProductImages): RedirectResponse
    {
        $manageProductImages->removeAll($product);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado.');
    }

    private function productData(StoreProductRequest|UpdateProductRequest $request): array
    {
        return [
            ...$request->safe()->except([
                'image_urls',
                'images',
                'removed_image_ids',
                'is_featured',
                'is_active',
            ]),
            'slug' => Str::slug($request->string('name')->toString()),
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ];
    }

    /**
     * @return list<string>
     */
    private function imageUrls(StoreProductRequest|UpdateProductRequest $request): array
    {
        $urls = [
            $request->validated('image_url'),
            ...$request->validated('image_urls', []),
        ];

        return collect($urls)
            ->filter(fn (mixed $url): bool => is_string($url) && trim($url) !== '')
            ->map(fn (string $url): string => trim($url))
            ->unique()
            ->values()
            ->all();
    }
}
