@extends('layouts.admin')

@section('title', 'Nueva categoría')
@section('page-label', 'Crear categoría')

@section('content')
    <div class="mx-auto mb-7 max-w-2xl"><a class="text-sm font-semibold text-slate-500 hover:text-brand" href="{{ route('admin.categories.index') }}">← Volver a categorías</a><h1 class="mt-3 text-3xl font-black tracking-tight text-slate-950">Nueva categoría</h1></div>
    <form method="POST" action="{{ route('admin.categories.store') }}">@csrf @include('admin.categories._form')</form>
@endsection
