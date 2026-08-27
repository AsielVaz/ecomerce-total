@extends('layouts.admin')

@section('title', 'Categorías')
@section('page-label', 'Categorías del catálogo')

@section('content')
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div><p class="text-sm font-bold uppercase tracking-[0.16em] text-brand">Organización</p><h1 class="mt-2 text-3xl font-black tracking-tight text-slate-950">Categorías</h1><p class="mt-2 text-sm text-slate-500">Agrupa el catálogo para que sea fácil de descubrir.</p></div>
        <a class="btn-primary" href="{{ route('admin.categories.create') }}">+ Nueva categoría</a>
    </div>

    <div class="mt-7 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @forelse ($categories as $category)
            <article class="surface-card p-5">
                <div class="flex items-start justify-between gap-4">
                    <span class="grid size-11 place-items-center rounded-xl bg-brand-soft text-lg font-black text-brand">{{ mb_substr($category->name, 0, 1) }}</span>
                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $category->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $category->is_active ? 'Activa' : 'Oculta' }}</span>
                </div>
                <h2 class="mt-5 text-lg font-bold text-slate-950">{{ $category->name }}</h2>
                <p class="mt-2 line-clamp-2 min-h-10 text-sm leading-5 text-slate-500">{{ $category->description ?: 'Sin descripción.' }}</p>
                <p class="mt-4 text-xs font-semibold text-slate-400">{{ $category->products_count }} {{ Str::plural('producto', $category->products_count) }}</p>
                <div class="mt-5 flex gap-2 border-t border-slate-100 pt-4">
                    <a class="btn-secondary min-h-9 flex-1 px-3 py-2 text-xs" href="{{ route('admin.categories.edit', $category) }}">Editar</a>
                    <form class="flex-1" method="POST" action="{{ route('admin.categories.destroy', $category) }}" data-confirm="¿Eliminar esta categoría? Sus productos quedarán sin categoría.">
                        @csrf @method('DELETE')
                        <button class="min-h-9 w-full rounded-xl border border-rose-100 px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50" type="submit">Eliminar</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-400">Aún no hay categorías.</div>
        @endforelse
    </div>
    @if ($categories->hasPages())<div class="mt-7">{{ $categories->links() }}</div>@endif
@endsection
