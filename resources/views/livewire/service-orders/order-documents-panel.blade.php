<div class="space-y-6">
    <x-page-header :title="__('documents.panel.title_for', ['number' => $order->order_number])"
                   :description="__('documents.panel.client_label', ['name' => $order->client?->display_name ?? '—'])">
        <x-slot:actions>
            <a href="{{ route('app.service-orders.show', $order->id) }}"
               class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                {{ __('documents.panel.back_to_order') }}
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="text-lg font-semibold tracking-tight text-slate-900">{{ __('documents.panel.generate_documents') }}</h3>

        <div class="mt-4 flex flex-wrap gap-3">
            <button type="button" wire:click="generateInvoice" class="cursor-pointer rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
                {{ __('documents.actions.generate_invoice') }}
            </button>
            <button type="button" wire:click="generateIntakeAct" class="cursor-pointer rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                {{ __('documents.actions.generate_intake_act') }}
            </button>
            <button type="button" wire:click="generateCompletionAct" class="cursor-pointer rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                {{ __('documents.actions.generate_completion_act') }}
            </button>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-5 py-4">
            <h3 class="text-lg font-semibold tracking-tight text-slate-900">{{ __('documents.panel.generated_documents') }}</h3>
        </div>

        @if ($documents->isEmpty())
            <div class="p-5">
                <x-empty-state :title="__('documents.panel.empty_title')" :description="__('documents.panel.empty_description')" />
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-5 py-3 font-medium">{{ __('documents.table.type') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('documents.table.number') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('documents.table.date') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('documents.table.status') }}</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $document)
                            @php
                                $type = $document->document_type->value ?? $document->document_type;
                                $status = $document->status->value ?? $document->status;
                            @endphp
                            <tr class="border-t border-slate-200">
                                <td class="px-5 py-3 text-slate-700">{{ __('documents.types.' . $type) }}</td>
                                <td class="px-5 py-3 font-medium text-slate-900">{{ $document->document_number }}</td>
                                <td class="px-5 py-3 text-slate-700">{{ optional($document->document_date)->format('d.m.Y') }}</td>
                                <td class="px-5 py-3 text-slate-700">{{ __('documents.status.' . $status) }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex flex-wrap justify-end gap-2">
                                        @if ($document->html_path)
                                            <a href="{{ route('app.documents.html', $document->id) }}" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                                {{ __('documents.actions.html') }}
                                            </a>
                                        @endif
                                        @if ($document->pdf_path)
                                            <a href="{{ route('app.documents.pdf', $document->id) }}" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                                {{ __('documents.actions.pdf') }}
                                            </a>
                                        @endif
                                        @if ($status !== 'voided')
                                            <button type="button" wire:click="voidDocument({{ $document->id }})" class="cursor-pointer rounded-xl border border-rose-300 bg-white px-3 py-2 text-xs font-medium text-rose-700 hover:bg-rose-50">
                                                {{ __('documents.actions.void') }}
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
