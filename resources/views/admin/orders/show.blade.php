@extends('layouts.admin')

@section('title', 'Pedido '.$order->order_number)
@section('page-label', 'Detalle de pedido')

@section('content')
    <a class="text-sm font-semibold text-slate-500 hover:text-brand" href="{{ route('admin.orders.index') }}">← Volver a pedidos</a>
    <div class="mt-4 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div><p class="text-sm font-bold uppercase tracking-[0.16em] text-brand">Detalle de venta</p><h1 class="mt-2 text-3xl font-black tracking-tight text-slate-950">{{ $order->order_number }}</h1><p class="mt-2 text-sm text-slate-500">{{ $order->placed_at->translatedFormat('d M Y, H:i') }}</p></div>
        <form class="flex gap-2" method="POST" action="{{ route('admin.orders.update', $order) }}">
            @csrf @method('PATCH')
            <label class="sr-only" for="status">Estado</label>
            <select class="form-input min-w-48" id="status" name="status">@foreach ($statuses as $status)<option value="{{ $status->value }}" @selected($order->status === $status)>{{ $status->label() }}</option>@endforeach</select>
            <button class="btn-primary shrink-0" type="submit">Actualizar</button>
        </form>
    </div>

    <div class="mt-7 grid gap-6 xl:grid-cols-[1fr_340px]">
        <section class="surface-card overflow-hidden">
            <div class="border-b border-slate-100 px-6 py-5"><h2 class="font-bold text-slate-950">Productos del pedido</h2></div>
            <div class="divide-y divide-slate-100">
                @foreach ($order->items as $item)
                    <div class="flex gap-4 p-5 sm:p-6">
                        <div class="size-16 shrink-0 overflow-hidden rounded-xl bg-slate-100">@if ($item->product?->image_url)<img class="size-full object-cover" src="{{ $item->product->image_url }}" alt="">@endif</div>
                        <div class="min-w-0 grow"><p class="font-bold text-slate-900">{{ $item->product_name }}</p><p class="mt-1 text-xs text-slate-400">{{ $item->sku }} · {{ $item->quantity }} unidad(es)</p></div>
                        <p class="font-black text-slate-900">${{ number_format((float) $item->line_total, 2) }}</p>
                    </div>
                @endforeach
            </div>
            <dl class="ml-auto grid max-w-sm gap-3 border-t border-slate-100 p-6 text-sm">
                <div class="flex justify-between"><dt class="text-slate-500">Subtotal</dt><dd class="font-semibold">${{ number_format((float) $order->subtotal, 2) }}</dd></div>
                <div class="flex justify-between border-t border-slate-100 pt-3 text-base"><dt class="font-bold">Total</dt><dd class="text-xl font-black">${{ number_format((float) $order->total, 2) }} <span class="text-xs text-slate-400">{{ $order->currency }}</span></dd></div>
            </dl>
        </section>

        <aside class="grid h-fit gap-5">
            <div class="surface-card p-5"><p class="text-xs font-bold uppercase tracking-wider text-slate-400">Cliente</p><p class="mt-3 font-bold text-slate-900">{{ $order->customer_name }}</p><p class="mt-1 text-sm text-slate-500">{{ $order->customer_email }}</p><p class="mt-4 text-xs text-slate-400">Cuenta #{{ $order->user_id ?? 'eliminada' }}</p></div>
            <div class="rounded-2xl bg-slate-950 p-5 text-white"><p class="text-xs font-bold uppercase tracking-wider text-slate-500">Estado actual</p><p class="mt-3 text-xl font-black">{{ $order->status->label() }}</p><p class="mt-2 text-xs leading-5 text-slate-400">Actualiza el selector superior para reflejar el avance del pedido.</p></div>
        </aside>
    </div>
@endsection
