@props(['title', 'description' => null, 'actions' => null])

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div>
        <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ $title }}</h2>
        @if ($description)
            <p class="mt-1 text-sm text-slate-500">{{ $description }}</p>
        @endif
    </div>

    @if ($actions)
        <div>{{ $actions }}</div>
    @endif
</div>
