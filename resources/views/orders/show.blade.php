@extends('layouts.app')

@section('title', 'Pedido '.$order->order_number)

@section('content')
    <section class="container-page py-10 sm:py-14">
        <a class="text-sm font-semibold text-slate-500 hover:text-brand" href="{{ route('orders.index') }}">← Volver a mis pedidos</a>

        <div class="mt-6"><x-flash-message /></div>

        <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_340px]">
            <div class="surface-card overflow-hidden">
                <div class="border-b border-slate-100 p-6 sm:p-8">
                    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                        <div>
                            <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand">Pedido confirmado</p>
                            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-950">{{ $order->order_number }}</h1>
                            <p class="mt-2 text-sm text-slate-500">Realizado el {{ $order->placed_at->translatedFormat('d \d\e F \d\e Y, H:i') }}</p>
                        </div>
                        <span class="status-pill w-fit px-4 py-2">{{ $order->status->label() }}</span>
                    </div>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach ($order->items as $item)
                        <div class="flex gap-5 p-6 sm:p-8">
                            <div class="size-24 shrink-0 overflow-hidden rounded-2xl bg-slate-100">
                                @if ($item->product?->primaryImageUrl())
                                    <img class="size-full object-cover" src="{{ $item->product->primaryImageUrl() }}" alt="{{ $item->product_name }}">
                                @else
                                    <span class="grid size-full place-items-center text-2xl font-black text-brand/40">{{ mb_substr($item->product_name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="min-w-0 grow">
                                <h2 class="font-bold text-slate-950">{{ $item->product_name }}</h2>
                                <p class="mt-1 text-xs text-slate-400">SKU {{ $item->sku }} · Cantidad {{ $item->quantity }}</p>
                                <p class="mt-4 font-black text-slate-900">${{ number_format((float) $item->line_total, 2) }} {{ $order->currency }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <aside class="h-fit rounded-2xl bg-slate-950 p-6 text-white shadow-soft">
                <h2 class="text-lg font-bold">Resumen</h2>
                <dl class="mt-6 grid gap-4 text-sm">
                    <div class="flex justify-between gap-4 text-slate-400"><dt>Subtotal</dt><dd class="font-semibold text-white">${{ number_format((float) $order->subtotal, 2) }}</dd></div>
                    <div class="flex justify-between gap-4 text-slate-400"><dt>Envío</dt><dd class="font-semibold text-emerald-400">Incluido</dd></div>
                    <div class="flex justify-between gap-4 border-t border-white/10 pt-4 text-base"><dt class="font-bold">Total</dt><dd class="text-xl font-black">${{ number_format((float) $order->total, 2) }} <span class="text-xs text-slate-500">{{ $order->currency }}</span></dd></div>
                </dl>
                <div class="mt-7 rounded-xl bg-white/5 p-4 text-xs leading-5 text-slate-400">
                    Confirmación enviada a <span class="font-semibold text-white">{{ $order->customer_email }}</span>
                </div>
                <a class="btn-primary mt-5 w-full bg-white text-slate-950 hover:bg-accent" href="{{ route('home') }}#productos">Comprar otra vez</a>
            </aside>
        </div>
    </section>
@endsection
