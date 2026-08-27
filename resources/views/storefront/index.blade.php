@extends('layouts.app')

@section('title', 'Productos para todos los días')

@section('content')
    <section class="overflow-hidden bg-slate-950 text-white">
        <div class="container-page relative grid min-h-[560px] items-center gap-10 py-16 lg:grid-cols-[1.1fr_0.9fr] lg:py-20">
            <div class="relative z-10 max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] text-white/90">
                    <span class="size-2 rounded-full bg-accent"></span> Selección DTOUCHO 2026
                </span>
                <h1 class="mt-7 text-5xl font-black leading-[0.98] tracking-[-0.04em] sm:text-6xl lg:text-7xl">Todo lo que quieres. <span class="text-accent">En un solo lugar.</span></h1>
                <p class="mt-6 max-w-xl text-base leading-7 text-slate-300 sm:text-lg">Tecnología, hogar, moda y mucho más. Seleccionamos productos útiles, actuales y listos para hacer mejor tu día.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a class="btn-primary bg-white text-slate-950 shadow-white/10 hover:bg-accent hover:text-slate-950" href="#productos">Explorar productos →</a>
                    <a class="inline-flex min-h-11 items-center justify-center rounded-xl border border-white/20 px-5 py-2.5 text-sm font-semibold text-white hover:bg-white/10" href="#categorias">Ver categorías</a>
                </div>
                <div class="mt-10 grid max-w-lg grid-cols-3 gap-5 border-t border-white/10 pt-7">
                    <div><p class="text-2xl font-black">12+</p><p class="mt-1 text-xs text-slate-400">Productos selectos</p></div>
                    <div><p class="text-2xl font-black">6</p><p class="mt-1 text-xs text-slate-400">Categorías</p></div>
                    <div><p class="text-2xl font-black">24/7</p><p class="mt-1 text-xs text-slate-400">Tienda disponible</p></div>
                </div>
            </div>

            <div class="relative hidden h-[430px] lg:block" aria-hidden="true">
                <div class="absolute inset-8 rounded-[3rem] bg-gradient-to-br from-brand via-violet-500 to-cyan-400 opacity-80 blur-3xl"></div>
                @if ($featuredProducts->isNotEmpty())
                    <div class="absolute left-4 top-0 w-64 rotate-[-5deg] overflow-hidden rounded-[2rem] border border-white/20 bg-white p-3 shadow-2xl">
                        <img class="aspect-[4/3] w-full rounded-[1.4rem] object-cover" src="{{ $featuredProducts[0]->image_url }}" alt="">
                        <div class="p-3 text-slate-950"><p class="text-xs font-semibold text-brand">Favorito</p><p class="mt-1 font-bold">{{ $featuredProducts[0]->name }}</p></div>
                    </div>
                @endif
                @if ($featuredProducts->count() > 1)
                    <div class="absolute bottom-0 right-0 w-64 rotate-6 overflow-hidden rounded-[2rem] border border-white/20 bg-white p-3 shadow-2xl">
                        <img class="aspect-[4/3] w-full rounded-[1.4rem] object-cover" src="{{ $featuredProducts[1]->image_url }}" alt="">
                        <div class="p-3 text-slate-950"><p class="text-xs font-semibold text-brand">Trending</p><p class="mt-1 font-bold">{{ $featuredProducts[1]->name }}</p></div>
                    </div>
                @endif
                <div class="absolute right-10 top-8 grid size-20 place-items-center rounded-3xl border border-white/20 bg-white/10 text-4xl backdrop-blur">✦</div>
            </div>
        </div>
    </section>

    <section class="container-page py-12 sm:py-16" id="categorias">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand">Encuentra lo tuyo</p>
                <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">Compra por categoría</h2>
            </div>
            @if ($categorySlug)
                <a class="text-sm font-semibold text-brand hover:text-brand-dark" href="{{ route('home') }}#productos">Limpiar filtro ×</a>
            @endif
        </div>

        <div class="mt-7 flex snap-x gap-3 overflow-x-auto pb-3">
            @foreach ($categories as $category)
                <a class="min-w-44 snap-start rounded-2xl border p-4 {{ $categorySlug === $category->slug ? 'border-brand bg-brand text-white' : 'border-slate-200 bg-white text-slate-700 hover:border-brand/30 hover:text-brand' }}" href="{{ route('home', ['category' => $category->slug]) }}#productos">
                    <span class="block font-bold">{{ $category->name }}</span>
                    <span class="mt-1 block text-xs {{ $categorySlug === $category->slug ? 'text-white/70' : 'text-slate-400' }}">{{ $category->products_count }} productos</span>
                </a>
            @endforeach
        </div>
    </section>

    @if (! $search && ! $categorySlug && $featuredProducts->isNotEmpty())
        <section class="container-page pb-14">
            <div class="rounded-[2rem] bg-brand-soft p-6 sm:p-8">
                <div class="mb-7 flex items-end justify-between gap-4">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand">Lo más deseado</p>
                        <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-950 sm:text-3xl">Favoritos de la semana</h2>
                    </div>
                    <a class="hidden text-sm font-semibold text-brand sm:block" href="#productos">Ver todo ↓</a>
                </div>
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($featuredProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="container-page pb-8" id="productos">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand">Catálogo</p>
                <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">
                    @if ($search)
                        Resultados para “{{ $search }}”
                    @elseif ($categorySlug)
                        {{ $categories->firstWhere('slug', $categorySlug)?->name ?? 'Productos' }}
                    @else
                        Descubre algo nuevo
                    @endif
                </h2>
            </div>
            <form class="flex w-full max-w-lg gap-2" method="GET" action="{{ route('home') }}#productos" role="search">
                @if ($categorySlug)<input type="hidden" name="category" value="{{ $categorySlug }}">@endif
                <label class="sr-only" for="search">Buscar productos</label>
                <input class="form-input" id="search" name="search" type="search" value="{{ $search }}" placeholder="Buscar por nombre o SKU...">
                <button class="btn-primary shrink-0" type="submit">Buscar</button>
            </form>
        </div>

        <x-flash-message />

        @if ($products->isEmpty())
            <div class="mt-8 rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-20 text-center">
                <p class="text-5xl">⌕</p>
                <h3 class="mt-4 text-xl font-bold text-slate-900">No encontramos productos</h3>
                <p class="mt-2 text-sm text-slate-500">Prueba con otra palabra o elimina los filtros actuales.</p>
                <a class="btn-primary mt-6" href="{{ route('home') }}#productos">Ver todo el catálogo</a>
            </div>
        @else
            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-10">{{ $products->links() }}</div>
        @endif
    </section>

    <section class="container-page py-12">
        <div class="grid overflow-hidden rounded-[2rem] bg-slate-950 text-white lg:grid-cols-[1fr_auto]">
            <div class="p-8 sm:p-12">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-accent">Compra simple</p>
                <h2 class="mt-3 max-w-2xl text-3xl font-black tracking-tight sm:text-4xl">Elige lo que te gusta y confirma tu pedido en un clic.</h2>
                <p class="mt-4 max-w-xl text-sm leading-6 text-slate-400">Crea tu cuenta para conservar tus pedidos y consultar su estado desde cualquier dispositivo.</p>
            </div>
            <div class="flex items-center p-8 pt-0 lg:p-12">
                @guest<a class="btn-primary bg-accent text-slate-950 hover:bg-white" href="{{ route('register') }}">Crear mi cuenta →</a>@else<a class="btn-primary bg-accent text-slate-950 hover:bg-white" href="{{ route('orders.index') }}">Ver mis pedidos →</a>@endguest
            </div>
        </div>
    </section>
@endsection
