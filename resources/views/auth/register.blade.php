@extends('layouts.app')

@section('title', 'Crear cuenta')

@section('content')
    <section class="container-page py-12 sm:py-16">
        <div class="mx-auto grid max-w-5xl overflow-hidden rounded-[2rem] bg-white shadow-soft lg:grid-cols-[0.9fr_1.1fr]">
            <div class="relative hidden overflow-hidden bg-slate-950 p-10 text-white lg:block">
                <div class="absolute -right-20 -top-20 size-72 rounded-full bg-brand/50 blur-3xl"></div>
                <div class="relative flex h-full flex-col">
                    <span class="text-sm font-bold uppercase tracking-[0.18em] text-accent">Únete a DTOUCHO</span>
                    <h1 class="mt-5 text-4xl font-black leading-tight tracking-tight">Tu próxima compra empieza aquí.</h1>
                    <p class="mt-4 text-sm leading-7 text-slate-400">Crea una cuenta para comprar en un clic, guardar tu historial y consultar cada pedido.</p>
                    <div class="mt-auto grid gap-4 pt-12 text-sm text-slate-300">
                        <div class="flex items-center gap-3"><span class="grid size-8 place-items-center rounded-full bg-white/10 text-accent">✓</span> Registro rápido y gratuito</div>
                        <div class="flex items-center gap-3"><span class="grid size-8 place-items-center rounded-full bg-white/10 text-accent">✓</span> Pedidos siempre disponibles</div>
                        <div class="flex items-center gap-3"><span class="grid size-8 place-items-center rounded-full bg-white/10 text-accent">✓</span> Experiencia de compra simple</div>
                    </div>
                </div>
            </div>

            <div class="p-7 sm:p-10 lg:p-12">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand">Nueva cuenta</p>
                <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-950">Bienvenido a DTOUCHO</h2>
                <p class="mt-2 text-sm text-slate-500">Completa tus datos para empezar.</p>

                <div class="mt-6"><x-flash-message /></div>

                <form class="mt-7 grid gap-5" method="POST" action="{{ route('register.store') }}">
                    @csrf
                    <div>
                        <label class="form-label" for="name">Nombre completo</label>
                        <input class="form-input" id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required autofocus placeholder="Tu nombre">
                    </div>
                    <div>
                        <label class="form-label" for="email">Correo electrónico</label>
                        <input class="form-input" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required placeholder="tu@correo.com">
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="form-label" for="password">Contraseña</label>
                            <input class="form-input" id="password" name="password" type="password" autocomplete="new-password" required placeholder="8+ caracteres">
                        </div>
                        <div>
                            <label class="form-label" for="password_confirmation">Confirmar</label>
                            <input class="form-input" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required placeholder="Repite tu contraseña">
                        </div>
                    </div>
                    <p class="text-xs leading-5 text-slate-400">Usa al menos 8 caracteres, incluyendo letras y números.</p>
                    <button class="btn-primary w-full py-3.5" type="submit">Crear mi cuenta →</button>
                </form>

                <p class="mt-7 text-center text-sm text-slate-500">¿Ya tienes cuenta? <a class="font-bold text-brand hover:text-brand-dark" href="{{ route('login') }}">Inicia sesión</a></p>
            </div>
        </div>
    </section>
@endsection
