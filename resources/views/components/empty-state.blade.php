@props(['title', 'description' => null])

<div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">
    <h3 class="text-lg font-semibold text-slate-900">{{ $title }}</h3>
    @if ($description)
        <p class="mt-2 text-sm text-slate-500">{{ $description }}</p>
    @endif
</div>
