<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-semibold tracking-tight text-slate-900">{{ __('service_orders.sections.add_item') }}</h3>

    <form wire:submit="save" class="mt-4 space-y-5">
        <div class="flex flex-wrap gap-4">
            <div class="w-full max-w-xs">
                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('common.labels.type') }}</label>
                <select wire:model="type" class="w-full cursor-pointer rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    <option value="work">{{ __('service_orders.item_type.work') }}</option>
                    <option value="part">{{ __('service_orders.item_type.part') }}</option>
                </select>
                @error('type') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div class="w-full max-w-[180px]">
                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.position') }}</label>
                <input type="number" wire:model="position" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                @error('position') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
            </div>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.generic.name') }}</label>
            <input type="text" wire:model="name" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            @error('name') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.generic.description') }}</label>
            <textarea wire:model="description" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea>
        </div>

        <div class="flex flex-wrap gap-4">
            <div class="w-full max-w-[160px]">
                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.quantity') }}</label>
                <input type="number" step="0.01" wire:model="quantity" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                @error('quantity') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div class="w-full max-w-[180px]">
                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.unit_price') }}</label>
                <input type="number" step="0.01" wire:model="unit_price" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                @error('unit_price') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div class="w-full max-w-[180px]">
                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.cost_price') }}</label>
                <input type="number" step="0.01" wire:model="cost_price" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                @error('cost_price') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="cursor-pointer rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
                {{ __('service_orders.sections.add_item') }}
            </button>
        </div>
    </form>
</div>
