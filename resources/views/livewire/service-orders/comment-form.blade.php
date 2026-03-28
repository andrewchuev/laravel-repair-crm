<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-semibold tracking-tight text-slate-900">{{ __('service_orders.sections.add_comment') }}</h3>

    <form wire:submit="save" class="mt-4 space-y-4">
        <div class="w-full max-w-xs">
            <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.visibility') }}</label>
            <select wire:model="visibility" class="w-full cursor-pointer rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                <option value="internal">{{ __('service_orders.comment_visibility.internal') }}</option>
                <option value="public">{{ __('service_orders.comment_visibility.public') }}</option>
            </select>
            @error('visibility') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('service_orders.fields.body') }}</label>
            <textarea wire:model="body" rows="4" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea>
            @error('body') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="cursor-pointer rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
                {{ __('service_orders.sections.add_comment') }}
            </button>
        </div>
    </form>
</div>
