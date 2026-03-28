<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-4 flex items-center justify-between gap-3">
        <h3 class="text-lg font-semibold tracking-tight text-slate-900">{{ __('service_orders.sections.works_parts') }}</h3>
        <div class="text-sm text-slate-500">
            {{ __('common.labels.total') }}: <x-money :amount="$order->final_price" />
        </div>
    </div>

    @if ($items->isEmpty())
        <x-empty-state :title="__('service_orders.empty.items_title')" :description="__('service_orders.empty.items_description')" />
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-left text-slate-500">
                    <tr>
                        <th class="px-4 py-3 font-medium">{{ __('common.labels.type') }}</th>
                        <th class="px-4 py-3 font-medium">{{ __('service_orders.generic.name') }}</th>
                        <th class="px-4 py-3 font-medium">{{ __('service_orders.fields.quantity') }}</th>
                        <th class="px-4 py-3 font-medium">{{ __('service_orders.generic.unit_short') }}</th>
                        <th class="px-4 py-3 font-medium">{{ __('service_orders.fields.total_price') }}</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        @php
                            $itemType = $item->type->value ?? $item->type;
                        @endphp
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-3 text-slate-700">{{ __('service_orders.item_type.' . $itemType) }}</td>
                            <td class="px-4 py-3 text-slate-900">
                                <div class="font-medium">{{ $item->name }}</div>
                                @if ($item->description)
                                    <div class="mt-1 text-xs text-slate-500">{{ $item->description }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-700">{{ $item->quantity }}</td>
                            <td class="px-4 py-3"><x-money :amount="$item->unit_price" /></td>
                            <td class="px-4 py-3"><x-money :amount="$item->total_price" /></td>
                            <td class="px-4 py-3 text-right">
                                <button type="button"
                                        wire:click="deleteItem({{ $item->id }})"
                                        wire:confirm="{{ __('service_orders.confirm_delete_item') }}"
                                        class="cursor-pointer rounded-xl border border-rose-300 bg-white px-3 py-2 text-xs font-medium text-rose-700 hover:bg-rose-50">
                                    {{ __('common.actions.delete') }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
