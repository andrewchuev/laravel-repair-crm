<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-semibold tracking-tight text-slate-900">{{ __('attachments.upload_title') }}</h3>

    <form wire:submit="save" class="mt-4 space-y-5">
        <div class="w-full max-w-sm">
            <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('attachments.fields.type') }}</label>
            <select wire:model="type" class="w-full cursor-pointer rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                @foreach (['intake_photo', 'damage_photo', 'serial_photo', 'diagnostic_photo', 'repair_photo', 'final_photo', 'document', 'receipt', 'warranty', 'other'] as $typeOption)
                    <option value="{{ $typeOption }}">{{ __('attachments.types.' . $typeOption) }}</option>
                @endforeach
            </select>
            @error('type') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('attachments.fields.file') }}</label>
            <input type="file" wire:model="file" class="block w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            <div class="mt-1 text-xs text-slate-500">{{ __('attachments.upload_help.allowed_formats') }}</div>
            @error('file') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
            <div wire:loading wire:target="file" class="mt-2 text-xs text-slate-500">{{ __('attachments.upload_help.uploading') }}</div>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('attachments.fields.description') }}</label>
            <textarea wire:model="description" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea>
            @error('description') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" wire:model="is_primary" class="cursor-pointer rounded border-slate-300">
                {{ __('attachments.fields.is_primary') }}
            </label>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="cursor-pointer rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
                {{ __('common.actions.upload') }}
            </button>
        </div>
    </form>
</div>
