<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('search')->toString());
        $categorySlug = $request->string('category')->toString();

        $products = Product::query()
            ->active()
            ->with(['category', 'images'])
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $searchQuery) use ($search): void {
                    $searchQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($categorySlug !== '', function (Builder $query) use ($categorySlug): void {
                $query->whereHas('category', fn (Builder $categoryQuery): Builder => $categoryQuery->where('slug', $categorySlug));
            })
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        $featuredProducts = Product::query()
            ->active()
            ->where('is_featured', true)
            ->with(['category', 'images'])
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();

        $categories = Category::query()
            ->where('is_active', true)
            ->withCount(['products' => fn (Builder $query): Builder => $query->active()])
            ->orderBy('name')
            ->get();

        return view('storefront.index', compact('products', 'featuredProducts', 'categories', 'search', 'categorySlug'));
    }
}
