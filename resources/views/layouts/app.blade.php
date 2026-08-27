<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'DTOUCHO: productos que hacen mejor tu día, en un solo lugar.')">
    <meta property="og:type" content="@yield('meta_type', 'website')">
    <meta property="og:title" content="@yield('meta_title', 'DTOUCHO · Todo lo que quieres. En un solo lugar.')">
    <meta property="og:description" content="@yield('meta_description', 'Tecnología, hogar, moda y mucho más en una experiencia de compra simple y moderna.')">
    <meta property="og:image" content="@yield('meta_image', asset('og.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('meta_title', 'DTOUCHO · Todo lo que quieres. En un solo lugar.')">
    <meta name="twitter:description" content="@yield('meta_description', 'Tecnología, hogar, moda y mucho más en una experiencia de compra simple y moderna.')">
    <meta name="twitter:image" content="@yield('meta_image', asset('og.png'))">
    <title>@yield('title', 'Descubre algo increíble') · DTOUCHO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
    <div class="bg-slate-950 px-4 py-2 text-center text-xs font-medium text-white">
        Compra segura · Atención personalizada · Envíos a todo México
    </div>

    <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
        <div class="container-page flex min-h-18 items-center justify-between gap-4 py-3">
            <x-logo />

            <nav class="hidden items-center gap-7 text-sm font-semibold text-slate-600 md:flex" aria-label="Navegación principal">
                <a class="hover:text-brand" href="{{ route('home') }}#productos">Productos</a>
                <a class="hover:text-brand" href="{{ route('home') }}#categorias">Categorías</a>
                @auth
                    <a class="hover:text-brand" href="{{ route('orders.index') }}">Mis pedidos</a>
                    @if (auth()->user()->is_admin)
                        <a class="rounded-lg bg-slate-950 px-3 py-2 text-white hover:bg-brand" href="{{ route('admin.dashboard') }}">Administrar</a>
                    @endif
                @endauth
            </nav>

            <div class="hidden items-center gap-3 sm:flex">
                @guest
                    <a class="text-sm font-semibold text-slate-600 hover:text-brand" href="{{ route('login') }}">Iniciar sesión</a>
                    <a class="btn-primary" href="{{ route('register') }}">Crear cuenta</a>
                @else
                    <span class="hidden text-sm text-slate-500 lg:inline">Hola, <strong class="text-slate-800">{{ str(auth()->user()->name)->before(' ') }}</strong></span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm font-semibold text-slate-500 hover:text-rose-600" type="submit">Salir</button>
                    </form>
                @endguest
            </div>

            <details class="relative md:hidden">
                <summary class="grid size-11 cursor-pointer list-none place-items-center rounded-xl border border-slate-200 bg-white text-lg font-bold">☰</summary>
                <div class="absolute right-0 mt-3 w-64 rounded-2xl border border-slate-200 bg-white p-3 shadow-soft">
                    <div class="grid gap-1 text-sm font-semibold text-slate-700">
                        <a class="rounded-xl px-3 py-2.5 hover:bg-brand-soft hover:text-brand" href="{{ route('home') }}#productos">Productos</a>
                        <a class="rounded-xl px-3 py-2.5 hover:bg-brand-soft hover:text-brand" href="{{ route('home') }}#categorias">Categorías</a>
                        @auth
                            <a class="rounded-xl px-3 py-2.5 hover:bg-brand-soft hover:text-brand" href="{{ route('orders.index') }}">Mis pedidos</a>
                            @if (auth()->user()->is_admin)
                                <a class="rounded-xl px-3 py-2.5 hover:bg-brand-soft hover:text-brand" href="{{ route('admin.dashboard') }}">Administrar</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full rounded-xl px-3 py-2.5 text-left hover:bg-rose-50 hover:text-rose-600" type="submit">Cerrar sesión</button>
                            </form>
                        @else
                            <a class="rounded-xl px-3 py-2.5 hover:bg-brand-soft hover:text-brand" href="{{ route('login') }}">Iniciar sesión</a>
                            <a class="mt-1 rounded-xl bg-brand px-3 py-2.5 text-center text-white" href="{{ route('register') }}">Crear cuenta</a>
                        @endauth
                    </div>
                </div>
            </details>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="mt-20 border-t border-slate-200 bg-white">
        <div class="container-page grid gap-10 py-12 md:grid-cols-[1.2fr_1fr_1fr]">
            <div>
                <x-logo />
                <p class="mt-4 max-w-sm text-sm leading-6 text-slate-500">Una selección inteligente de tecnología, hogar, moda y mucho más. Todo lo que te gusta, en un solo lugar.</p>
            </div>
            <div>
                <p class="font-bold text-slate-900">Explora</p>
                <div class="mt-4 grid gap-3 text-sm text-slate-500">
                    <a class="hover:text-brand" href="{{ route('home') }}#productos">Todos los productos</a>
                    <a class="hover:text-brand" href="{{ route('home') }}#categorias">Categorías</a>
                    @auth<a class="hover:text-brand" href="{{ route('orders.index') }}">Mis pedidos</a>@endauth
                </div>
            </div>
            <div>
                <p class="font-bold text-slate-900">Compra con confianza</p>
                <div class="mt-4 grid gap-3 text-sm text-slate-500">
                    <span>Precios en pesos mexicanos</span>
                    <span>Inventario actualizado</span>
                    <span>Soporte DTOUCHO</span>
                </div>
            </div>
        </div>
        <div class="border-t border-slate-100 py-5 text-center text-xs text-slate-400">© {{ date('Y') }} DTOUCHO. Hecho para descubrir.</div>
    </footer>
</body>
</html>
