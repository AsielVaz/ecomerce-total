@extends('layouts.admin')

@section('title', 'Editar '.$product->name)
@section('page-label', 'Editar producto')

@section('content')
    <div class="mb-7"><a class="text-sm font-semibold text-slate-500 hover:text-brand" href="{{ route('admin.products.index') }}">← Volver a productos</a><h1 class="mt-3 text-3xl font-black tracking-tight text-slate-950">Editar producto</h1><p class="mt-2 text-sm text-slate-500">{{ $product->name }}</p></div>
    <form method="POST" action="{{ route('admin.products.update', $product) }}">
        @csrf @method('PUT')
        @include('admin.products._form')
    </form>
@endsection
