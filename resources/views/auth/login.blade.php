@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
    <section class="container-page py-12 sm:py-16">
        <div class="mx-auto grid max-w-4xl overflow-hidden rounded-[2rem] bg-white shadow-soft lg:grid-cols-2">
            <div class="relative hidden overflow-hidden bg-brand p-10 text-white lg:block">
                <div class="absolute -bottom-16 -left-16 size-64 rounded-full bg-cyan-300/30 blur-3xl"></div>
                <div class="relative flex h-full flex-col">
                    <span class="text-sm font-bold uppercase tracking-[0.18em] text-white/70">Hola de nuevo</span>
                    <h1 class="mt-5 text-4xl font-black leading-tight tracking-tight">Tus favoritos te están esperando.</h1>
                    <p class="mt-4 text-sm leading-7 text-white/75">Ingresa para comprar, revisar tus pedidos y volver a descubrir el catálogo DTOUCHO.</p>
                    <div class="mt-auto rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur">
                        <p class="text-sm font-semibold">“Todo lo que quieres. En un solo lugar.”</p>
                        <p class="mt-2 text-xs text-white/60">Experiencia DTOUCHO</p>
                    </div>
                </div>
            </div>

            <div class="p-7 sm:p-10 lg:p-12">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand">Acceso</p>
                <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-950">Inicia sesión</h2>
                <p class="mt-2 text-sm text-slate-500">Continúa donde lo dejaste.</p>

                <div class="mt-6"><x-flash-message /></div>

                <form class="mt-7 grid gap-5" method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <div>
                        <label class="form-label" for="email">Correo electrónico</label>
                        <input class="form-input" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus placeholder="tu@correo.com">
                    </div>
                    <div>
                        <label class="form-label" for="password">Contraseña</label>
                        <input class="form-input" id="password" name="password" type="password" autocomplete="current-password" required placeholder="Tu contraseña">
                    </div>
                    <label class="flex cursor-pointer items-center gap-3 text-sm text-slate-600">
                        <input class="size-4 rounded border-slate-300 text-brand focus:ring-brand" name="remember" type="checkbox" value="1">
                        Mantener mi sesión abierta
                    </label>
                    <button class="btn-primary w-full py-3.5" type="submit">Entrar a DTOUCHO →</button>
                </form>

                <p class="mt-7 text-center text-sm text-slate-500">¿Primera vez aquí? <a class="font-bold text-brand hover:text-brand-dark" href="{{ route('register') }}">Crea tu cuenta</a></p>
            </div>
        </div>
    </section>
@endsection
