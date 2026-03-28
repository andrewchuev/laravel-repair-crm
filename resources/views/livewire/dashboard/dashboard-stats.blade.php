<div class="space-y-6">
    <div class="flex items-center justify-end">
        <a href="{{ route('app.service-orders.create') }}"
           class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
            {{ __('dashboard.actions.create_order') }}
        </a>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-sm text-slate-500">{{ __('dashboard.stats.active_orders') }}</div>
            <div class="mt-2 text-3xl font-semibold tracking-tight">{{ $stats['active'] }}</div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-sm text-slate-500">{{ __('dashboard.stats.diagnostics') }}</div>
            <div class="mt-2 text-3xl font-semibold tracking-tight">{{ $stats['diagnostics'] }}</div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-sm text-slate-500">{{ __('dashboard.stats.awaiting_approval') }}</div>
            <div class="mt-2 text-3xl font-semibold tracking-tight">{{ $stats['awaiting_approval'] }}</div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-sm text-slate-500">{{ __('dashboard.stats.waiting_parts') }}</div>
            <div class="mt-2 text-3xl font-semibold tracking-tight">{{ $stats['waiting_parts'] }}</div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-sm text-slate-500">{{ __('dashboard.stats.ready') }}</div>
            <div class="mt-2 text-3xl font-semibold tracking-tight">{{ $stats['ready'] }}</div>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="text-lg font-semibold tracking-tight text-slate-900">{{ __('dashboard.sections.recent_orders') }}</h2>
        </div>

        @if ($recentOrders->isEmpty())
            <div class="p-5">
                <x-empty-state
                    :title="__('dashboard.empty.recent_orders_title')"
                    :description="__('dashboard.empty.recent_orders_description')"
                />
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-5 py-3 font-medium">{{ __('dashboard.table.order') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('dashboard.table.client') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('dashboard.table.item') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('dashboard.table.status') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('dashboard.table.received') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentOrders as $order)
                            <tr class="border-t border-slate-200">
                                <td class="px-5 py-3 font-medium text-slate-900">
                                    <a href="{{ route('app.service-orders.show', $order->id) }}" class="hover:underline">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="px-5 py-3 text-slate-700">{{ $order->client?->display_name ?? '—' }}</td>
                                <td class="px-5 py-3 text-slate-700">{{ $order->item_name }}</td>
                                <td class="px-5 py-3">
                                    <x-status-badge :status="$order->status->value ?? $order->status" />
                                </td>
                                <td class="px-5 py-3 text-slate-500">{{ optional($order->received_at)->format('d.m.Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
