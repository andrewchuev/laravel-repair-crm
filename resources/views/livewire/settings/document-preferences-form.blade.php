<div class="space-y-6">
    <x-page-header title="Document Preferences" description="Prefixes, locale and document texts." />

    <form wire:submit="save" class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Locale</label><input type="text" wire:model="document_locale" class="w-full max-w-[120px] rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Invoice prefix</label><input type="text" wire:model="invoice_prefix" class="w-full max-w-[140px] rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Intake prefix</label><input type="text" wire:model="intake_act_prefix" class="w-full max-w-[140px] rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Completion prefix</label><input type="text" wire:model="completion_act_prefix" class="w-full max-w-[140px] rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Warranty prefix</label><input type="text" wire:model="warranty_prefix" class="w-full max-w-[140px] rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div class="md:col-span-2"><label class="mb-1 block text-sm font-medium text-slate-700">Number format</label><input type="text" wire:model="number_format" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-sm font-medium text-slate-700">Default city</label><input type="text" wire:model="default_city" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></div>
                <div class="md:col-span-2 xl:col-span-4"><label class="mb-1 block text-sm font-medium text-slate-700">Invoice footer</label><textarea wire:model="invoice_footer" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea></div>
                <div class="md:col-span-2 xl:col-span-4"><label class="mb-1 block text-sm font-medium text-slate-700">Intake terms</label><textarea wire:model="intake_terms" rows="5" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea></div>
                <div class="md:col-span-2 xl:col-span-4"><label class="mb-1 block text-sm font-medium text-slate-700">Completion terms</label><textarea wire:model="completion_terms" rows="5" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea></div>
                <div class="md:col-span-2 xl:col-span-4"><label class="mb-1 block text-sm font-medium text-slate-700">Warranty terms</label><textarea wire:model="warranty_terms" rows="4" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea></div>
                <div class="md:col-span-2 xl:col-span-4"><label class="mb-1 block text-sm font-medium text-slate-700">Storage terms</label><textarea wire:model="storage_terms" rows="4" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm"></textarea></div>
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="cursor-pointer rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">Save document settings</button>
        </div>
    </form>
</div>
