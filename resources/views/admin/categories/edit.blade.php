@extends('layouts.admin')

@section('title', 'Editar '.$category->name)
@section('page-label', 'Editar categoría')

@section('content')
    <div class="mx-auto mb-7 max-w-2xl"><a class="text-sm font-semibold text-slate-500 hover:text-brand" href="{{ route('admin.categories.index') }}">← Volver a categorías</a><h1 class="mt-3 text-3xl font-black tracking-tight text-slate-950">Editar categoría</h1></div>
    <form method="POST" action="{{ route('admin.categories.update', $category) }}">@csrf @method('PUT') @include('admin.categories._form')</form>
@endsection
