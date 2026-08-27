@php($editing = isset($product))

<div class="grid gap-6 lg:grid-cols-[1fr_320px]">
    <div class="surface-card p-5 sm:p-7">
        <h2 class="text-lg font-bold text-slate-950">Información del producto</h2>
        <div class="mt-6 grid gap-5">
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="form-label" for="name">Nombre</label>
                    <input class="form-input" id="name" name="name" type="text" value="{{ old('name', $product->name ?? '') }}" required>
                </div>
                <div>
                    <label class="form-label" for="sku">SKU</label>
                    <input class="form-input uppercase" id="sku" name="sku" type="text" value="{{ old('sku', $product->sku ?? '') }}" required placeholder="DTO-CAT-001">
                </div>
            </div>
            <div>
                <label class="form-label" for="category_id">Categoría</label>
                <select class="form-input" id="category_id" name="category_id">
                    <option value="">Sin categoría</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) old('category_id', $product->category_id ?? '') === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label" for="short_description">Descripción corta</label>
                <input class="form-input" id="short_description" name="short_description" type="text" maxlength="180" value="{{ old('short_description', $product->short_description ?? '') }}" required>
                <p class="mt-1 text-xs text-slate-400">Aparece en las tarjetas del catálogo.</p>
            </div>
            <div>
                <label class="form-label" for="description">Descripción completa</label>
                <textarea class="form-input min-h-36 resize-y" id="description" name="description" required>{{ old('description', $product->description ?? '') }}</textarea>
            </div>
            <div>
                <label class="form-label" for="image_url">URL de imagen</label>
                <input class="form-input" id="image_url" name="image_url" type="url" value="{{ old('image_url', $product->image_url ?? '') }}" placeholder="https://...">
            </div>
        </div>
    </div>

    <div class="grid h-fit gap-6">
        <div class="surface-card p-5">
            <h2 class="font-bold text-slate-950">Precio e inventario</h2>
            <div class="mt-5 grid gap-4">
                <div><label class="form-label" for="price">Precio MXN</label><input class="form-input" id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $product->price ?? '') }}" required></div>
                <div><label class="form-label" for="compare_at_price">Precio anterior</label><input class="form-input" id="compare_at_price" name="compare_at_price" type="number" min="0" step="0.01" value="{{ old('compare_at_price', $product->compare_at_price ?? '') }}" placeholder="Opcional"></div>
                <div><label class="form-label" for="stock">Existencias</label><input class="form-input" id="stock" name="stock" type="number" min="0" step="1" value="{{ old('stock', $product->stock ?? 0) }}" required></div>
            </div>
        </div>
        <div class="surface-card p-5">
            <h2 class="font-bold text-slate-950">Visibilidad</h2>
            <div class="mt-5 grid gap-4">
                <input name="is_active" type="hidden" value="0">
                <label class="flex cursor-pointer items-start gap-3"><input class="mt-1 size-4 rounded border-slate-300 text-brand focus:ring-brand" name="is_active" type="checkbox" value="1" @checked(old('is_active', $product->is_active ?? true))><span><strong class="block text-sm text-slate-800">Producto activo</strong><span class="mt-1 block text-xs text-slate-400">Visible y disponible en la tienda.</span></span></label>
                <input name="is_featured" type="hidden" value="0">
                <label class="flex cursor-pointer items-start gap-3"><input class="mt-1 size-4 rounded border-slate-300 text-brand focus:ring-brand" name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $product->is_featured ?? false))><span><strong class="block text-sm text-slate-800">Producto destacado</strong><span class="mt-1 block text-xs text-slate-400">Aparece en la sección de favoritos.</span></span></label>
            </div>
        </div>
        <div class="flex gap-3">
            <a class="btn-secondary flex-1" href="{{ route('admin.products.index') }}">Cancelar</a>
            <button class="btn-primary flex-1" type="submit">{{ $editing ? 'Guardar' : 'Crear producto' }}</button>
        </div>
    </div>
</div>
