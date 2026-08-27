@extends('layouts.admin')

@section('title', 'Pedidos')
@section('page-label', 'Gestión de pedidos')

@section('content')
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div><p class="text-sm font-bold uppercase tracking-[0.16em] text-brand">Ventas</p><h1 class="mt-2 text-3xl font-black tracking-tight text-slate-950">Pedidos</h1><p class="mt-2 text-sm text-slate-500">Consulta compras y actualiza su avance.</p></div>
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <label class="sr-only" for="status">Filtrar por estado</label>
            <select class="form-input min-w-56" id="status" name="status" onchange="this.form.submit()">
                <option value="">Todos los estados</option>
                @foreach ($statuses as $orderStatus)<option value="{{ $orderStatus->value }}" @selected($status === $orderStatus->value)>{{ $orderStatus->label() }}</option>@endforeach
            </select>
        </form>
    </div>

    <div class="mt-7 surface-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-400"><tr><th class="px-5 py-3">Pedido</th><th class="px-5 py-3">Cliente</th><th class="px-5 py-3">Estado</th><th class="px-5 py-3">Fecha</th><th class="px-5 py-3 text-right">Total</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-5 py-4"><a class="font-bold text-slate-900 hover:text-brand" href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a><p class="mt-1 text-xs text-slate-400">{{ $order->items_count }} artículo(s)</p></td>
                            <td class="px-5 py-4"><p class="font-medium text-slate-700">{{ $order->customer_name }}</p><p class="mt-1 text-xs text-slate-400">{{ $order->customer_email }}</p></td>
                            <td class="px-5 py-4"><span class="status-pill">{{ $order->status->label() }}</span></td>
                            <td class="px-5 py-4 text-slate-500">{{ $order->placed_at->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-4 text-right font-black text-slate-900">${{ number_format((float) $order->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td class="px-5 py-12 text-center text-slate-400" colspan="5">No hay pedidos para este filtro.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($orders->hasPages())<div class="border-t border-slate-100 p-5">{{ $orders->links() }}</div>@endif
    </div>
@endsection
