<div class="space-y-6">
    <x-page-header
        :title="__('profile.title')"
        :description="__('profile.subtitle')"
    />

    <form wire:submit="save" class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        {{ __('profile.fields.name') }}
                    </label>
                    <input
                        type="text"
                        wire:model="name"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"
                    >
                    @error('name')
                        <div class="mt-1 text-xs text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        {{ __('profile.fields.email') }}
                    </label>
                    <input
                        type="email"
                        wire:model="email"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"
                    >
                    @error('email')
                        <div class="mt-1 text-xs text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        {{ __('profile.fields.language') }}
                    </label>
                    <select
                        wire:model="preferred_locale"
                        class="w-full max-w-xs rounded-xl border border-slate-300 px-3 py-2.5 text-sm cursor-pointer"
                    >
                        @foreach ($availableLocales as $locale => $label)
                            <option value="{{ $locale }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('preferred_locale')
                        <div class="mt-1 text-xs text-rose-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button
                type="submit"
                class="cursor-pointer rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800"
            >
                {{ __('profile.actions.save') }}
            </button>
        </div>
    </form>
</div>
