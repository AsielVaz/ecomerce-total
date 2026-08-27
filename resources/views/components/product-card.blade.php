@props(['product'])

<article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-soft">
    <a class="relative block aspect-[4/3] overflow-hidden bg-slate-100" href="{{ route('products.show', $product) }}">
        @if ($product->image_url)
            <img class="size-full object-cover transition duration-500 group-hover:scale-105" src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
        @else
            <span class="grid size-full place-items-center bg-gradient-to-br from-brand-soft to-slate-100 text-5xl font-black text-brand/30">{{ mb_substr($product->name, 0, 1) }}</span>
        @endif

        <div class="absolute left-3 top-3 flex flex-wrap gap-2">
            @if ($product->compare_at_price)
                <span class="rounded-full bg-rose-500 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide text-white">Oferta</span>
            @endif
            @if ($product->is_featured)
                <span class="rounded-full bg-slate-950 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide text-white">Top</span>
            @endif
        </div>
    </a>

    <div class="flex grow flex-col p-4 sm:p-5">
        <p class="text-xs font-semibold uppercase tracking-wider text-brand">{{ $product->category?->name ?? 'DTOUCHO' }}</p>
        <h3 class="mt-2 text-base font-bold leading-snug text-slate-950">
            <a class="hover:text-brand" href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
        </h3>
        <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500">{{ $product->short_description }}</p>

        <div class="mt-auto flex items-end justify-between gap-3 pt-5">
            <div>
                @if ($product->compare_at_price)
                    <p class="text-xs text-slate-400 line-through">${{ number_format((float) $product->compare_at_price, 2) }}</p>
                @endif
                <p class="text-lg font-black text-slate-950">${{ number_format((float) $product->price, 2) }} <span class="text-xs font-medium text-slate-400">MXN</span></p>
            </div>
            <a class="grid size-11 shrink-0 place-items-center rounded-xl bg-brand-soft font-bold text-brand hover:bg-brand hover:text-white" href="{{ route('products.show', $product) }}" aria-label="Ver {{ $product->name }}">→</a>
        </div>
    </div>
</article>
