@extends('layouts.app')

@section('title', 'Mis pedidos')

@section('content')
    <section class="container-page py-10 sm:py-14">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand">Mi cuenta</p>
                <h1 class="mt-2 text-4xl font-black tracking-tight text-slate-950">Mis pedidos</h1>
                <p class="mt-2 text-sm text-slate-500">Consulta las compras realizadas con tu cuenta DTOUCHO.</p>
            </div>
            <a class="btn-secondary" href="{{ route('home') }}#productos">Seguir comprando</a>
        </div>

        <div class="mt-8"><x-flash-message /></div>

        @if ($orders->isEmpty())
            <div class="mt-8 rounded-3xl border border-dashed border-slate-300 bg-white p-12 text-center sm:p-20">
                <span class="mx-auto grid size-16 place-items-center rounded-2xl bg-brand-soft text-3xl">□</span>
                <h2 class="mt-5 text-xl font-bold text-slate-900">Aún no tienes pedidos</h2>
                <p class="mt-2 text-sm text-slate-500">Tu próxima gran compra puede estar a un clic.</p>
                <a class="btn-primary mt-6" href="{{ route('home') }}#productos">Descubrir productos</a>
            </div>
        @else
            <div class="mt-8 grid gap-4">
                @foreach ($orders as $order)
                    <a class="group grid gap-5 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm hover:border-brand/20 hover:shadow-soft sm:grid-cols-[1fr_auto] sm:items-center" href="{{ route('orders.show', $order) }}">
                        <div class="flex items-start gap-4">
                            <span class="grid size-12 shrink-0 place-items-center rounded-xl bg-brand-soft font-black text-brand">#</span>
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="font-bold text-slate-950">{{ $order->order_number }}</h2>
                                    <span class="status-pill">{{ $order->status->label() }}</span>
                                </div>
                                <p class="mt-2 text-sm text-slate-500">{{ $order->placed_at->translatedFormat('d M Y, H:i') }} · {{ $order->items_count }} {{ Str::plural('artículo', $order->items_count) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-6 sm:justify-end">
                            <p class="text-lg font-black text-slate-950">${{ number_format((float) $order->total, 2) }} <span class="text-xs font-medium text-slate-400">{{ $order->currency }}</span></p>
                            <span class="grid size-10 place-items-center rounded-xl bg-slate-100 font-bold text-slate-500 group-hover:bg-brand group-hover:text-white">→</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">{{ $orders->links() }}</div>
        @endif
    </section>
@endsection
