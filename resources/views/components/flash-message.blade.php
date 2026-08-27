@if (session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800" role="status">
        <span class="mt-0.5 grid size-5 shrink-0 place-items-center rounded-full bg-emerald-600 text-xs text-white">✓</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800" role="alert">
        <p class="font-semibold">Revisa la información:</p>
        <ul class="mt-1 list-inside list-disc space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
