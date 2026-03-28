<div class="space-y-6">
    <x-page-header title="Business Profile" description="ФОП details used in generated documents." />

    <form wire:submit="save" class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <div class="xl:col-span-2"><label class="mb-1 block text-sm font-medium text-slate-700">Legal name</label><input type="text" wire:model="legal_name" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Short name</label><input type="text" wire:model="short_name" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Tax ID</label><input type="text" wire:model="tax_id" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Registration number</label><input type="text" wire:model="registration_number" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">VAT number</label><input type="text" wire:model="vat_number" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Locale</label><input type="text" wire:model="default_locale" class="w-full max-w-[120px] rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Phone</label><input type="text" wire:model="phone" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Email</label><input type="email" wire:model="email" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Website</label><input type="text" wire:model="website" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div class="md:col-span-2 xl:col-span-3"><label class="mb-1 block text-sm font-medium text-slate-700">Registration address</label><textarea wire:model="registration_address" rows="2" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea></div>
                <div class="md:col-span-2 xl:col-span-3"><label class="mb-1 block text-sm font-medium text-slate-700">Actual address</label><textarea wire:model="actual_address" rows="2" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">City</label><input type="text" wire:model="city" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Postal code</label><input type="text" wire:model="postal_code" class="w-full max-w-[180px] rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Signer name</label><input type="text" wire:model="signer_name" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Signer title</label><input type="text" wire:model="signer_title" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="cursor-pointer rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">Save profile</button>
        </div>
    </form>
</div>
