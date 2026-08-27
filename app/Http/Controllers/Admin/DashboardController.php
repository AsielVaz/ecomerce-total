<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\OrderStatus;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $statistics = [
            'revenue' => Order::query()->where('status', '!=', OrderStatus::Cancelled)->sum('total'),
            'orders' => Order::query()->count(),
            'products' => Product::query()->count(),
            'customers' => User::query()->where('is_admin', false)->count(),
            'low_stock' => Product::query()->where('is_active', true)->where('stock', '<=', 5)->count(),
            'categories' => Category::query()->count(),
        ];

        $recentOrders = Order::query()
            ->with('user')
            ->withCount('items')
            ->orderByDesc('placed_at')
            ->limit(6)
            ->get();

        return view('admin.dashboard', compact('statistics', 'recentOrders'));
    }
}
