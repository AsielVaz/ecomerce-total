@extends('layouts.app')

@section('title', $product->name)
@section('meta_type', 'product')
@section('meta_title', $product->name.' · DTOUCHO')
@section('meta_description', $product->short_description)
@section('meta_image', $product->image_url ?: '')

@section('content')
    <div class="container-page py-8 sm:py-12">
        <nav class="flex flex-wrap items-center gap-2 text-xs font-medium text-slate-400" aria-label="Migas de pan">
            <a class="hover:text-brand" href="{{ route('home') }}">Inicio</a><span>/</span>
            @if ($product->category)
                <a class="hover:text-brand" href="{{ route('home', ['category' => $product->category->slug]) }}#productos">{{ $product->category->name }}</a><span>/</span>
            @endif
            <span class="text-slate-600">{{ $product->name }}</span>
        </nav>

        <x-flash-message />

        <div class="mt-6 grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:gap-16">
            <div class="overflow-hidden rounded-[2rem] bg-white shadow-soft">
                @if ($product->image_url)
                    <img class="aspect-square size-full object-cover" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                @else
                    <div class="grid aspect-square place-items-center bg-gradient-to-br from-brand-soft to-slate-100 text-8xl font-black text-brand/30">{{ mb_substr($product->name, 0, 1) }}</div>
                @endif
            </div>

            <div class="flex flex-col justify-center">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="status-pill">{{ $product->category?->name ?? 'DTOUCHO' }}</span>
                    @if ($product->is_featured)<span class="rounded-full bg-slate-950 px-3 py-1 text-xs font-bold text-white">Favorito</span>@endif
                </div>
                <h1 class="mt-5 text-4xl font-black leading-tight tracking-[-0.035em] text-slate-950 sm:text-5xl">{{ $product->name }}</h1>
                <p class="mt-4 text-lg leading-8 text-slate-500">{{ $product->short_description }}</p>

                <div class="mt-7 flex items-end gap-3">
                    <p class="text-3xl font-black text-slate-950">${{ number_format((float) $product->price, 2) }} <span class="text-sm font-semibold text-slate-400">MXN</span></p>
                    @if ($product->compare_at_price)
                        <p class="pb-1 text-base text-slate-400 line-through">${{ number_format((float) $product->compare_at_price, 2) }}</p>
                    @endif
                </div>

                <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold text-slate-900">Disponibilidad</p>
                            <p class="mt-1 text-xs {{ $product->stock > 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $product->stock > 0 ? $product->stock.' piezas listas para ordenar' : 'Agotado temporalmente' }}</p>
                        </div>
                        <span class="text-xs font-medium text-slate-400">SKU {{ $product->sku }}</span>
                    </div>

                    @auth
                        <form class="mt-5" method="POST" action="{{ route('orders.store', $product) }}">
                            @csrf
                            <button class="btn-primary w-full py-3.5 text-base" type="submit" @disabled($product->stock < 1)>
                                {{ $product->stock > 0 ? 'Comprar ahora · $'.number_format((float) $product->price, 2) : 'Producto agotado' }}
                            </button>
                        </form>
                        <p class="mt-3 text-center text-xs text-slate-400">El pedido se confirma inmediatamente para este ejemplo.</p>
                    @else
                        <a class="btn-primary mt-5 w-full py-3.5 text-base" href="{{ route('login') }}">Inicia sesión para comprar</a>
                        <p class="mt-3 text-center text-xs text-slate-400">¿Aún no tienes cuenta? <a class="font-semibold text-brand" href="{{ route('register') }}">Regístrate gratis</a></p>
                    @endauth
                </div>

                <div class="mt-7 grid grid-cols-3 gap-3 text-center text-xs font-semibold text-slate-600">
                    <div class="rounded-xl bg-white p-3">✓ Compra simple</div>
                    <div class="rounded-xl bg-white p-3">↻ Soporte directo</div>
                    <div class="rounded-xl bg-white p-3">⌁ Stock real</div>
                </div>
            </div>
        </div>

        <section class="mt-14 grid gap-8 rounded-[2rem] bg-white p-7 sm:p-10 lg:grid-cols-[0.35fr_0.65fr]">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand">Detalles</p>
                <h2 class="mt-2 text-2xl font-black text-slate-950">Conoce tu próxima compra</h2>
            </div>
            <p class="whitespace-pre-line text-base leading-8 text-slate-600">{{ $product->description }}</p>
        </section>

        @if ($relatedProducts->isNotEmpty())
            <section class="mt-16">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand">También te puede gustar</p>
                <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-950">Más para descubrir</h2>
                <div class="mt-7 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($relatedProducts as $relatedProduct)
                        <x-product-card :product="$relatedProduct" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
