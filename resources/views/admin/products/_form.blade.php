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
            <section class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 sm:p-5">
                <div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-start">
                    <div>
                        <h3 class="font-bold text-slate-950">Galería de imágenes</h3>
                        <p class="mt-1 text-xs leading-5 text-slate-500">La primera imagen será la portada. Puedes combinar URLs y archivos subidos.</p>
                    </div>
                    <span class="w-fit rounded-full bg-white px-3 py-1 text-[11px] font-bold text-slate-500 shadow-sm">JPG, PNG o WEBP · 5 MB</span>
                </div>

                @if ($editing && $product->images->isNotEmpty())
                    <div class="mt-5">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Imágenes actuales</p>
                        <div class="mt-3 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                            @foreach ($product->images as $image)
                                <label class="group relative overflow-hidden rounded-xl border border-slate-200 bg-white p-2">
                                    <img class="aspect-[4/3] w-full rounded-lg object-cover" src="{{ $image->resolvedUrl() }}" alt="Imagen {{ $loop->iteration }} de {{ $product->name }}">
                                    <span class="mt-2 flex items-center gap-2 rounded-lg px-1 py-1 text-xs font-semibold text-slate-600 group-hover:text-rose-600">
                                        <input class="size-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500" name="removed_image_ids[]" type="checkbox" value="{{ $image->id }}" @checked(in_array($image->id, old('removed_image_ids', [])))>
                                        Retirar imagen
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-5">
                    <label class="form-label" for="image-url-0">Agregar mediante URL</label>
                    <div class="grid gap-2" data-image-url-list>
                        @foreach (old('image_urls', ['']) as $index => $imageUrl)
                            <div class="flex gap-2" data-image-url-row>
                                <input class="form-input" id="image-url-{{ $index }}" name="image_urls[]" type="url" value="{{ $imageUrl }}" placeholder="https://ejemplo.com/imagen.jpg">
                                <button class="grid size-12 shrink-0 place-items-center rounded-xl border border-slate-200 bg-white text-lg font-bold text-slate-400 hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600" type="button" data-remove-image-url aria-label="Quitar URL">×</button>
                            </div>
                        @endforeach
                    </div>
                    <button class="mt-3 inline-flex items-center gap-2 text-xs font-bold text-brand hover:text-brand-dark" type="button" data-add-image-url>＋ Agregar otra URL</button>
                    @if ($errors->has('image_urls') || $errors->has('image_urls.*'))
                        <p class="mt-2 text-xs font-semibold text-rose-600">{{ $errors->first('image_urls.*') ?: $errors->first('image_urls') }}</p>
                    @endif
                </div>

                <div class="mt-5">
                    <label class="form-label" for="images">Subir desde este dispositivo</label>
                    <label class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-white px-5 py-8 text-center hover:border-brand/50 hover:bg-brand-soft/40" for="images">
                        <span class="grid size-11 place-items-center rounded-full bg-brand-soft text-xl text-brand">↑</span>
                        <strong class="mt-3 text-sm text-slate-800">Seleccionar una o varias imágenes</strong>
                        <span class="mt-1 text-xs text-slate-400">Hasta 8 archivos por vez</span>
                    </label>
                    <input class="sr-only" id="images" name="images[]" type="file" accept="image/jpeg,image/png,image/webp" multiple data-image-file-input>
                    <p class="mt-2 text-xs font-medium text-slate-500" data-image-file-summary>Ningún archivo seleccionado.</p>
                    @if ($errors->has('images') || $errors->has('images.*'))
                        <p class="mt-2 text-xs font-semibold text-rose-600">{{ $errors->first('images.*') ?: $errors->first('images') }}</p>
                    @endif
                </div>
            </section>
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
