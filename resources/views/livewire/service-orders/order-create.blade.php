<div class="space-y-6">
    <x-page-header :title="__('service_orders.create.title')" :description="__('service_orders.create.subtitle')" />

    <form wire:submit="save" class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <div class="xl:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.client') }}</label>
                    <select wire:model="client_id" class="w-full cursor-pointer rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                        <option value="">{{ __('service_orders.create.select_client') }}</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->display_name }} — {{ $client->phone }}</option>
                        @endforeach
                    </select>
                    @error('client_id') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div class="w-full max-w-xs">
                    <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.priority') }}</label>
                    <select wire:model="priority" class="w-full cursor-pointer rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                        @foreach ($priorities as $priorityOption)
                            <option value="{{ $priorityOption }}">{{ __('service_orders.priority.' . $priorityOption) }}</option>
                        @endforeach
                    </select>
                    @error('priority') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div class="w-full max-w-xs">
                    <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.category') }}</label>
                    <select wire:model="category" class="w-full cursor-pointer rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                        @foreach ($categories as $categoryOption)
                            <option value="{{ $categoryOption }}">{{ __('service_orders.category.' . $categoryOption) }}</option>
                        @endforeach
                    </select>
                    @error('category') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div class="xl:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.item_name') }}</label>
                    <input type="text" wire:model="item_name" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    @error('item_name') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.brand') }}</label>
                    <input type="text" wire:model="brand" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.model') }}</label>
                    <input type="text" wire:model="model" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.serial_number') }}</label>
                    <input type="text" wire:model="serial_number" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                <div class="md:col-span-2 xl:col-span-3">
                    <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.reported_problem') }}</label>
                    <textarea wire:model="reported_problem" rows="4" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea>
                    @error('reported_problem') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div class="md:col-span-2 xl:col-span-3">
                    <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.intake_condition') }}</label>
                    <textarea wire:model="intake_condition" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea>
                </div>

                <div class="md:col-span-2 xl:col-span-3">
                    <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.accessories') }}</label>
                    <textarea wire:model="accessories" rows="2" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea>
                </div>

                <div class="w-full max-w-[180px]">
                    <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.estimated_price') }}</label>
                    <input type="number" step="0.01" wire:model="estimated_price" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    @error('estimated_price') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div class="w-full max-w-[180px]">
                    <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.agreed_price') }}</label>
                    <input type="number" step="0.01" wire:model="agreed_price" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    @error('agreed_price') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div class="md:col-span-2 xl:col-span-3">
                    <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.internal_notes') }}</label>
                    <textarea wire:model="internal_notes" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('app.service-orders.index') }}"
               class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                {{ __('common.actions.cancel') }}
            </a>

            <button type="submit"
                    class="cursor-pointer rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
                {{ __('service_orders.create.create_button') }}
            </button>
        </div>
    </form>
</div>
