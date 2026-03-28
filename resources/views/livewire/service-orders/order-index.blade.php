<div class="space-y-6">
    <x-page-header :title="__('service_orders.index.title')" :description="__('service_orders.index.subtitle')">
        <x-slot:actions>
            <a href="{{ route('app.service-orders.create') }}"
               class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
                {{ __('service_orders.index.create_button') }}
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="grid gap-3 xl:grid-cols-[1fr_180px_180px_auto]">
            <input type="text"
                   wire:model.live.debounce.300ms="search"
                   placeholder="{{ __('service_orders.index.search_placeholder') }}"
                   class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

            <select wire:model.live="status" class="w-full cursor-pointer rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                <option value="">{{ __('service_orders.index.all_statuses') }}</option>
                @foreach ($statuses as $statusOption)
                    <option value="{{ $statusOption }}">{{ __('service_orders.status.' . $statusOption) }}</option>
                @endforeach
            </select>

            <select wire:model.live="category" class="w-full cursor-pointer rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                <option value="">{{ __('service_orders.index.all_categories') }}</option>
                @foreach ($categories as $categoryOption)
                    <option value="{{ $categoryOption }}">{{ __('service_orders.category.' . $categoryOption) }}</option>
                @endforeach
            </select>

            <button type="button"
                    wire:click="resetFilters"
                    class="cursor-pointer rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                {{ __('common.actions.reset') }}
            </button>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        @if ($orders->isEmpty())
            <div class="p-5">
                <x-empty-state :title="__('service_orders.empty.orders_title')" :description="__('service_orders.empty.orders_description')" />
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-5 py-3 font-medium">{{ __('service_orders.fields.order_number') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('service_orders.fields.client') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('service_orders.fields.item_name') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('common.labels.status') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('service_orders.fields.assigned_master') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('service_orders.fields.final_price') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('service_orders.fields.paid_amount') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('service_orders.fields.balance_amount') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('service_orders.fields.received_at') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-t border-slate-200">
                                <td class="px-5 py-3 font-medium text-slate-900">
                                    <a href="{{ route('app.service-orders.show', $order->id) }}" class="hover:underline">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="px-5 py-3 text-slate-700">{{ $order->client?->display_name ?? '—' }}</td>
                                <td class="px-5 py-3 text-slate-700">{{ $order->item_name }}</td>
                                <td class="px-5 py-3"><x-status-badge :status="$order->status->value ?? $order->status" /></td>
                                <td class="px-5 py-3 text-slate-700">{{ $order->assignedMaster?->name ?? '—' }}</td>
                                <td class="px-5 py-3"><x-money :amount="$order->final_price" /></td>
                                <td class="px-5 py-3"><x-money :amount="$order->paid_amount" /></td>
                                <td class="px-5 py-3"><x-money :amount="$order->balance_amount" /></td>
                                <td class="px-5 py-3 text-slate-500">{{ optional($order->received_at)->format('d.m.Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-5 py-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
