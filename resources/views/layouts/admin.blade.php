<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Panel administrativo DTOUCHO.">
    <title>@yield('title', 'Administración') · DTOUCHO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100">
    <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
        <aside class="hidden min-h-screen bg-slate-950 p-5 text-white lg:block">
            <x-logo class="text-white" />
            <p class="mt-2 text-xs font-medium uppercase tracking-[0.2em] text-slate-500">Centro de control</p>

            <nav class="mt-10 grid gap-2 text-sm font-semibold" aria-label="Administración">
                <a class="rounded-xl px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-brand text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}" href="{{ route('admin.dashboard') }}">Resumen</a>
                <a class="rounded-xl px-4 py-3 {{ request()->routeIs('admin.products.*') ? 'bg-brand text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}" href="{{ route('admin.products.index') }}">Productos</a>
                <a class="rounded-xl px-4 py-3 {{ request()->routeIs('admin.categories.*') ? 'bg-brand text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}" href="{{ route('admin.categories.index') }}">Categorías</a>
                <a class="rounded-xl px-4 py-3 {{ request()->routeIs('admin.orders.*') ? 'bg-brand text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}" href="{{ route('admin.orders.index') }}">Pedidos</a>
            </nav>

            <div class="mt-10 border-t border-white/10 pt-6">
                <a class="block rounded-xl px-4 py-3 text-sm font-semibold text-slate-400 hover:bg-white/5 hover:text-white" href="{{ route('home') }}">← Ver tienda</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full rounded-xl px-4 py-3 text-left text-sm font-semibold text-slate-400 hover:bg-white/5 hover:text-white" type="submit">Cerrar sesión</button>
                </form>
            </div>
        </aside>

        <div class="min-w-0">
            <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur-xl">
                <div class="flex min-h-18 items-center justify-between gap-4 px-4 sm:px-6 lg:px-10">
                    <div class="lg:hidden"><x-logo /></div>
                    <div class="hidden lg:block">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Panel DTOUCHO</p>
                        <p class="text-sm font-semibold text-slate-700">@yield('page-label', 'Administración')</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden text-right sm:block">
                            <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400">Administrador</p>
                        </div>
                        <span class="grid size-10 place-items-center rounded-full bg-brand-soft text-sm font-black text-brand">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                        <details class="relative lg:hidden">
                            <summary class="cursor-pointer list-none rounded-lg border border-slate-200 px-3 py-2 text-sm font-bold">Menú</summary>
                            <nav class="absolute right-0 mt-3 grid w-56 gap-1 rounded-2xl border border-slate-200 bg-white p-3 text-sm font-semibold text-slate-700 shadow-soft">
                                <a class="rounded-lg px-3 py-2 hover:bg-brand-soft" href="{{ route('admin.dashboard') }}">Resumen</a>
                                <a class="rounded-lg px-3 py-2 hover:bg-brand-soft" href="{{ route('admin.products.index') }}">Productos</a>
                                <a class="rounded-lg px-3 py-2 hover:bg-brand-soft" href="{{ route('admin.categories.index') }}">Categorías</a>
                                <a class="rounded-lg px-3 py-2 hover:bg-brand-soft" href="{{ route('admin.orders.index') }}">Pedidos</a>
                                <a class="rounded-lg px-3 py-2 hover:bg-brand-soft" href="{{ route('home') }}">Ver tienda</a>
                            </nav>
                        </details>
                    </div>
                </div>
            </header>

            <main class="p-4 sm:p-6 lg:p-10">
                <x-flash-message />
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
