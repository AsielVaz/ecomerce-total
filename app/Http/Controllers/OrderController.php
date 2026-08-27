<?php

namespace App\Http\Controllers;

use App\Actions\CreateOrder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()
            ->orders()
            ->withCount('items')
            ->orderByDesc('placed_at')
            ->orderByDesc('id')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request, Product $product, CreateOrder $createOrder): RedirectResponse
    {
        $order = $createOrder->handle($request->user(), $product);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Tu compra se realizó correctamente.');
    }

    public function show(Request $request, Order $order): View
    {
        abort_unless((int) $order->user_id === (int) $request->user()->id, 404);

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }
}
