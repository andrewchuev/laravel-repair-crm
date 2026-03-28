<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-semibold tracking-tight text-slate-900">{{ __('service_orders.sections.status') }}</h3>

    @if ($successMessage)
        <div class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ $successMessage }}
        </div>
    @endif

    @if ($errorMessage)
        <div class="mt-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
            {{ $errorMessage }}
        </div>
    @endif

    <div class="mt-4 flex items-center gap-3">
        <div class="text-sm text-slate-500">{{ __('service_orders.generic.current') }}</div>
        <x-status-badge :status="$currentStatus" />
    </div>

    @if (count($nextStatuses) > 0)
        <form wire:submit="save" class="mt-4 space-y-4">
            <div class="w-full max-w-sm">
                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.generic.next_status') }}</label>
                <select wire:model="status" class="w-full cursor-pointer rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    <option value="">{{ __('service_orders.generic.select_status') }}</option>
                    @foreach ($nextStatuses as $statusOption)
                        <option value="{{ $statusOption }}">{{ __('service_orders.status.' . $statusOption) }}</option>
                    @endforeach
                </select>
                @error('status') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.body') }}</label>
                <textarea wire:model="comment" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea>
                @error('comment') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="cursor-pointer rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
                    {{ __('service_orders.actions.update_status') }}
                </button>
            </div>
        </form>
    @else
        <div class="mt-4 text-sm text-slate-500">{{ __('service_orders.messages.no_further_transitions') }}</div>
    @endif
</div>
