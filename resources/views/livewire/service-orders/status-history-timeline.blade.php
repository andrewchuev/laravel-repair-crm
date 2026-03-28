<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-4 flex items-center justify-between gap-3">
        <h3 class="text-lg font-semibold tracking-tight text-slate-900">{{ __('service_orders.sections.status_history') }}</h3>
        <div class="text-xs text-slate-500">{{ __('service_orders.counts.events', ['count' => $history->count()]) }}</div>
    </div>

    @if ($history->isEmpty())
        <x-empty-state :title="__('service_orders.empty.history_title')" :description="__('service_orders.empty.history_description')" />
    @else
        <div class="space-y-4">
            @foreach ($history as $item)
                <div class="relative pl-8">
                    <div class="absolute left-2 top-2 h-full w-px bg-slate-200"></div>
                    <div class="absolute left-0 top-1.5 h-4 w-4 rounded-full border-2 border-white bg-slate-900 shadow-sm"></div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div class="flex flex-wrap items-center gap-2 text-sm font-medium text-slate-900">
                                <x-status-badge :status="$item->old_status?->value ?? $item->old_status ?? 'new'" />
                                <span class="text-slate-400">→</span>
                                <x-status-badge :status="$item->new_status?->value ?? $item->new_status" />
                            </div>

                            <div class="text-xs text-slate-500">
                                {{ optional($item->created_at)->format('d.m.Y H:i') }}
                            </div>
                        </div>

                        <div class="mt-2 text-xs text-slate-500">
                            {{ $item->changedBy?->name ?? __('service_orders.messages.system') }}
                        </div>

                        @if ($item->comment)
                            <div class="mt-3 text-sm text-slate-700">
                                {{ $item->comment }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
