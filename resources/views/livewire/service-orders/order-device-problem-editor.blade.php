<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="flex items-start justify-between gap-4">
        <h3 class="text-lg font-semibold tracking-tight text-slate-900">
            {{ __('service_orders.sections.device_problem') }}
        </h3>

        @if (! $isEditing && $canEdit)
            <button
                type="button"
                wire:click="startEditing"
                class="cursor-pointer rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                {{ __('service_orders.device_editor.actions.edit') }}
            </button>
        @endif
    </div>

    @if (! $canEdit)
        <div class="mt-3 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
            {{ __('service_orders.device_editor.messages.read_only') }}
        </div>
    @endif

    @if ($isEditing)
        <form wire:submit="save" class="mt-4 space-y-6">
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        {{ __('service_orders.fields.category') }}
                    </label>
                    <select wire:model="category" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm cursor-pointer">
                        @foreach ($categories as $categoryOption)
                            <option value="{{ $categoryOption }}">
                                {{ __('service_orders.category.' . $categoryOption) }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="mt-1 text-xs text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        {{ __('service_orders.fields.serial_number') }}
                    </label>
                    <input wire:model="serial_number" type="text" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    @error('serial_number')
                        <div class="mt-1 text-xs text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        {{ __('service_orders.fields.item_name') }}
                    </label>
                    <input wire:model="item_name" type="text" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    @error('item_name')
                        <div class="mt-1 text-xs text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">
                            {{ __('service_orders.fields.brand') }}
                        </label>
                        <input wire:model="brand" type="text" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                        @error('brand')
                            <div class="mt-1 text-xs text-rose-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">
                            {{ __('service_orders.fields.model') }}
                        </label>
                        <input wire:model="model" type="text" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                        @error('model')
                            <div class="mt-1 text-xs text-rose-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        {{ __('service_orders.fields.reported_problem') }}
                    </label>
                    <textarea wire:model="reported_problem" rows="4" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea>
                    @error('reported_problem')
                        <div class="mt-1 text-xs text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        {{ __('service_orders.fields.intake_condition') }}
                    </label>
                    <textarea wire:model="intake_condition" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea>
                    @error('intake_condition')
                        <div class="mt-1 text-xs text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        {{ __('service_orders.fields.accessories') }}
                    </label>
                    <textarea wire:model="accessories" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea>
                    @error('accessories')
                        <div class="mt-1 text-xs text-rose-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button
                    type="button"
                    wire:click="cancelEditing"
                    class="cursor-pointer rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50"
                >
                    {{ __('service_orders.device_editor.actions.cancel') }}
                </button>
                <button
                    type="submit"
                    class="cursor-pointer rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800"
                >
                    {{ __('service_orders.device_editor.actions.save') }}
                </button>
            </div>
        </form>
    @else
        <dl class="mt-4 grid gap-4 md:grid-cols-2">
            <div>
                <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('service_orders.fields.item_name') }}</dt>
                <dd class="mt-1 text-sm text-slate-900">{{ $order->item_name ?: '—' }}</dd>
            </div>

            <div>
                <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('service_orders.fields.brand') }} / {{ __('service_orders.fields.model') }}</dt>
                <dd class="mt-1 text-sm text-slate-900">
                    {{ trim(($order->brand ?: '') . ' ' . ($order->model ?: '')) ?: '—' }}
                </dd>
            </div>

            <div>
                <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('service_orders.fields.category') }}</dt>
                <dd class="mt-1 text-sm text-slate-900">{{ __('service_orders.category.' . ($order->category->value ?? $order->category)) }}</dd>
            </div>

            <div>
                <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('service_orders.fields.serial_number') }}</dt>
                <dd class="mt-1 text-sm text-slate-900">{{ $order->serial_number ?: '—' }}</dd>
            </div>

            <div class="md:col-span-2">
                <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('service_orders.fields.reported_problem') }}</dt>
                <dd class="mt-1 text-sm text-slate-900">{{ $order->reported_problem }}</dd>
            </div>

            <div class="md:col-span-2">
                <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('service_orders.fields.intake_condition') }}</dt>
                <dd class="mt-1 text-sm text-slate-900">{{ $order->intake_condition ?: '—' }}</dd>
            </div>

            <div class="md:col-span-2">
                <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('service_orders.fields.accessories') }}</dt>
                <dd class="mt-1 text-sm text-slate-900">{{ $order->accessories ?: '—' }}</dd>
            </div>
        </dl>
    @endif
</div>
