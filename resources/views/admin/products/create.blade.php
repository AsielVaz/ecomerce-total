@extends('layouts.admin')

@section('title', 'Nuevo producto')
@section('page-label', 'Crear producto')

@section('content')
    <div class="mb-7"><a class="text-sm font-semibold text-slate-500 hover:text-brand" href="{{ route('admin.products.index') }}">← Volver a productos</a><h1 class="mt-3 text-3xl font-black tracking-tight text-slate-950">Nuevo producto</h1></div>
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.products._form')
    </form>
@endsection
