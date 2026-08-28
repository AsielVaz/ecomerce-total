@extends('layouts.admin')

@section('title', 'Productos')
@section('page-label', 'Catálogo de productos')

@section('content')
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand">Catálogo</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-950">Productos</h1>
            <p class="mt-2 text-sm text-slate-500">Controla precios, disponibilidad y contenido.</p>
        </div>
        <a class="btn-primary" href="{{ route('admin.products.create') }}">+ Nuevo producto</a>
    </div>

    <div class="mt-7 surface-card overflow-hidden">
        <div class="border-b border-slate-100 p-4 sm:p-5">
            <form class="flex max-w-lg gap-2" method="GET" action="{{ route('admin.products.index') }}">
                <label class="sr-only" for="product-search">Buscar producto</label>
                <input class="form-input" id="product-search" name="search" type="search" value="{{ $search }}" placeholder="Buscar por nombre o SKU...">
                <button class="btn-secondary shrink-0" type="submit">Buscar</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[840px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-400">
                    <tr><th class="px-5 py-3">Producto</th><th class="px-5 py-3">Categoría</th><th class="px-5 py-3">Precio</th><th class="px-5 py-3">Stock</th><th class="px-5 py-3">Estado</th><th class="px-5 py-3 text-right">Acciones</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-12 shrink-0 overflow-hidden rounded-xl bg-slate-100">@if ($product->primaryImageUrl())<img class="size-full object-cover" src="{{ $product->primaryImageUrl() }}" alt="">@endif</div>
                                    <div><p class="font-bold text-slate-900">{{ $product->name }}</p><p class="mt-1 text-xs text-slate-400">{{ $product->sku }}</p></div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $product->category?->name ?? 'Sin categoría' }}</td>
                            <td class="px-5 py-4 font-bold text-slate-900">${{ number_format((float) $product->price, 2) }}</td>
                            <td class="px-5 py-4"><span class="font-bold {{ $product->stock <= 5 ? 'text-amber-600' : 'text-slate-700' }}">{{ $product->stock }}</span></td>
                            <td class="px-5 py-4"><span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $product->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $product->is_active ? 'Activo' : 'Oculto' }}</span></td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:border-brand hover:text-brand" href="{{ route('admin.products.edit', $product) }}">Editar</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" data-confirm="¿Eliminar este producto? Los pedidos existentes conservarán su información.">
                                        @csrf @method('DELETE')
                                        <button class="rounded-lg border border-rose-100 px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="px-5 py-12 text-center text-slate-400" colspan="6">No hay productos que coincidan con la búsqueda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($products->hasPages())<div class="border-t border-slate-100 p-5">{{ $products->links() }}</div>@endif
    </div>
@endsection
