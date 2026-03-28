<div class="space-y-6">
    <x-page-header :title="$clientId ? 'Edit Client' : 'Create Client'"
                   description="Use a compact form for person or company records." />

    <form wire:submit="save" class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Type</label>
                    <select wire:model.live="type" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                        <option value="person">Person</option>
                        <option value="company">Company</option>
                    </select>
                    @error('type') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Phone</label>
                    <input type="text" wire:model="phone" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    @error('phone') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                @if ($type === 'person')
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700">Full name</label>
                        <input type="text" wire:model="full_name" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                        @error('full_name') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                    </div>
                @else
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700">Company name</label>
                        <input type="text" wire:model="company_name" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                        @error('company_name') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                    </div>
                @endif

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Secondary phone</label>
                    <input type="text" wire:model="phone_secondary" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" wire:model="email" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    @error('email') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Source</label>
                    <input type="text" wire:model="source" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-slate-700">Notes</label>
                    <textarea wire:model="notes" rows="5" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('app.clients.index') }}"
               class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Cancel
            </a>

            <button type="submit"
                    class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
                {{ $clientId ? 'Save changes' : 'Create client' }}
            </button>
        </div>
    </form>
</div>
