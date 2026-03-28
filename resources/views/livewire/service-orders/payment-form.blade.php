<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-semibold tracking-tight text-slate-900">{{ __('service_orders.sections.record_payment') }}</h3>

    <form wire:submit="save" class="mt-4 space-y-5">
        <div class="flex flex-wrap gap-4">
            <div class="w-full max-w-xs">
                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('payments.fields.type') }}</label>
                <select wire:model="type" class="w-full cursor-pointer rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    <option value="payment">{{ __('payments.types.payment') }}</option>
                    <option value="refund">{{ __('payments.types.refund') }}</option>
                </select>
                @error('type') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div class="w-full max-w-xs">
                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('payments.fields.method') }}</label>
                <select wire:model="method" class="w-full cursor-pointer rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    <option value="cash">{{ __('payments.methods.cash') }}</option>
                    <option value="card">{{ __('payments.methods.card') }}</option>
                    <option value="bank_transfer">{{ __('payments.methods.bank_transfer') }}</option>
                    <option value="other">{{ __('payments.methods.other') }}</option>
                </select>
                @error('method') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div class="w-full max-w-[180px]">
                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('payments.fields.amount') }}</label>
                <input type="number" step="0.01" wire:model="amount" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                @error('amount') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
            </div>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('payments.fields.comment') }}</label>
            <textarea wire:model="comment" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea>
            @error('comment') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="cursor-pointer rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
                {{ __('service_orders.actions.save_payment') }}
            </button>
        </div>
    </form>
</div>
