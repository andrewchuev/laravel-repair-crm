<div class="space-y-6">
    <x-page-header title="Bank Accounts" description="Payment requisites for invoices and acts." />

    <form wire:submit="save" class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Title</label><input type="text" wire:model="title" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div class="md:col-span-2"><label class="mb-1 block text-sm font-medium text-slate-700">Recipient</label><input type="text" wire:model="recipient" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div class="md:col-span-2"><label class="mb-1 block text-sm font-medium text-slate-700">IBAN</label><input type="text" wire:model="iban" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Currency</label><input type="text" wire:model="currency" class="w-full max-w-[120px] rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div class="md:col-span-2"><label class="mb-1 block text-sm font-medium text-slate-700">Bank name</label><input type="text" wire:model="bank_name" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Bank MFO</label><input type="text" wire:model="bank_mfo" class="w-full max-w-[180px] rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Bank EDRPOU</label><input type="text" wire:model="bank_edrpou" class="w-full max-w-[180px] rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div class="md:col-span-2 xl:col-span-3"><label class="mb-1 block text-sm font-medium text-slate-700">Payment purpose template</label><textarea wire:model="payment_purpose_template" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea></div>
                <div class="flex flex-wrap gap-6 md:col-span-2 xl:col-span-3">
                    <label class="inline-flex items-center gap-2 text-sm text-slate-700"><input type="checkbox" wire:model="is_default" class="cursor-pointer rounded border-slate-300"> Default account</label>
                    <label class="inline-flex items-center gap-2 text-sm text-slate-700"><input type="checkbox" wire:model="is_active" class="cursor-pointer rounded border-slate-300"> Active</label>
                </div>
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="cursor-pointer rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">Save bank account</button>
        </div>
    </form>
</div>
