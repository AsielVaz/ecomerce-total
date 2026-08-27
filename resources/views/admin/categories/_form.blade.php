@php($editing = isset($category))

<div class="mx-auto max-w-2xl surface-card p-6 sm:p-8">
    <div class="grid gap-5">
        <div>
            <label class="form-label" for="name">Nombre</label>
            <input class="form-input" id="name" name="name" type="text" value="{{ old('name', $category->name ?? '') }}" required autofocus placeholder="Ej. Tecnología">
        </div>
        <div>
            <label class="form-label" for="description">Descripción</label>
            <textarea class="form-input min-h-32 resize-y" id="description" name="description" placeholder="Describe qué encontrará el cliente...">{{ old('description', $category->description ?? '') }}</textarea>
        </div>
        <input name="is_active" type="hidden" value="0">
        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 p-4">
            <input class="mt-1 size-4 rounded border-slate-300 text-brand focus:ring-brand" name="is_active" type="checkbox" value="1" @checked(old('is_active', $category->is_active ?? true))>
            <span><strong class="block text-sm text-slate-800">Categoría activa</strong><span class="mt-1 block text-xs text-slate-400">Visible como filtro dentro de la tienda.</span></span>
        </label>
        <div class="flex gap-3 pt-2">
            <a class="btn-secondary flex-1" href="{{ route('admin.categories.index') }}">Cancelar</a>
            <button class="btn-primary flex-1" type="submit">{{ $editing ? 'Guardar' : 'Crear categoría' }}</button>
        </div>
    </div>
</div>
