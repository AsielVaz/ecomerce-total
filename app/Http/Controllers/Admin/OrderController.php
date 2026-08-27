<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderStatusRequest;
use App\Models\Order;
use App\OrderStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $orders = Order::query()
            ->with('user')
            ->withCount('items')
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->orderByDesc('placed_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $statuses = OrderStatus::cases();

        return view('admin.orders.index', compact('orders', 'statuses', 'status'));
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'user']);
        $statuses = OrderStatus::cases();

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function update(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $order->update($request->validated());

        return redirect()->route('admin.orders.show', $order)->with('success', 'Estado del pedido actualizado.');
    }
}
