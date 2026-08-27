@extends('layouts.admin')

@section('title', 'Resumen')
@section('page-label', 'Resumen de la tienda')

@section('content')
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand">Hoy en DTOUCHO</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">Tu tienda, de un vistazo</h1>
            <p class="mt-2 text-sm text-slate-500">Inventario, clientes y ventas actualizados.</p>
        </div>
        <a class="btn-primary" href="{{ route('admin.products.create') }}">+ Nuevo producto</a>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="surface-card p-5">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Ingresos totales</p>
            <p class="mt-3 text-3xl font-black text-slate-950">${{ number_format((float) $statistics['revenue'], 2) }}</p>
            <p class="mt-2 text-xs font-semibold text-emerald-600">MXN en pedidos no cancelados</p>
        </div>
        <div class="surface-card p-5">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Pedidos</p>
            <p class="mt-3 text-3xl font-black text-slate-950">{{ number_format($statistics['orders']) }}</p>
            <a class="mt-2 inline-block text-xs font-semibold text-brand" href="{{ route('admin.orders.index') }}">Gestionar pedidos →</a>
        </div>
        <div class="surface-card p-5">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Catálogo</p>
            <p class="mt-3 text-3xl font-black text-slate-950">{{ number_format($statistics['products']) }}</p>
            <p class="mt-2 text-xs text-slate-400">{{ $statistics['categories'] }} categorías activas o archivadas</p>
        </div>
        <div class="surface-card p-5">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Clientes</p>
            <p class="mt-3 text-3xl font-black text-slate-950">{{ number_format($statistics['customers']) }}</p>
            <p class="mt-2 text-xs {{ $statistics['low_stock'] > 0 ? 'font-semibold text-amber-600' : 'text-slate-400' }}">{{ $statistics['low_stock'] }} productos con stock bajo</p>
        </div>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-[1fr_320px]">
        <section class="surface-card overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-6">
                <div><h2 class="font-bold text-slate-950">Pedidos recientes</h2><p class="mt-1 text-xs text-slate-400">Última actividad de compra</p></div>
                <a class="text-sm font-semibold text-brand" href="{{ route('admin.orders.index') }}">Ver todos</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[640px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-400">
                        <tr><th class="px-6 py-3">Pedido</th><th class="px-6 py-3">Cliente</th><th class="px-6 py-3">Estado</th><th class="px-6 py-3 text-right">Total</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentOrders as $order)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4"><a class="font-bold text-slate-900 hover:text-brand" href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a><p class="mt-1 text-xs text-slate-400">{{ $order->placed_at->format('d/m/Y H:i') }}</p></td>
                                <td class="px-6 py-4"><p class="font-medium text-slate-700">{{ $order->customer_name }}</p><p class="mt-1 text-xs text-slate-400">{{ $order->items_count }} artículo(s)</p></td>
                                <td class="px-6 py-4"><span class="status-pill">{{ $order->status->label() }}</span></td>
                                <td class="px-6 py-4 text-right font-black text-slate-900">${{ number_format((float) $order->total, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td class="px-6 py-10 text-center text-slate-400" colspan="4">Aún no hay pedidos.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="rounded-2xl bg-slate-950 p-6 text-white shadow-soft">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-accent">Acciones rápidas</p>
            <h2 class="mt-3 text-2xl font-black">Mantén todo al día</h2>
            <div class="mt-6 grid gap-3">
                <a class="rounded-xl border border-white/10 bg-white/5 p-4 text-sm font-semibold hover:bg-white/10" href="{{ route('admin.products.create') }}">Añadir producto <span class="float-right">→</span></a>
                <a class="rounded-xl border border-white/10 bg-white/5 p-4 text-sm font-semibold hover:bg-white/10" href="{{ route('admin.categories.create') }}">Crear categoría <span class="float-right">→</span></a>
                <a class="rounded-xl border border-white/10 bg-white/5 p-4 text-sm font-semibold hover:bg-white/10" href="{{ route('home') }}">Revisar tienda <span class="float-right">↗</span></a>
            </div>
        </aside>
    </div>
@endsection
