<?php

namespace App\Modules\Documents\Presentation\Livewire;

use App\Modules\Documents\Application\Actions\GenerateWorkshopDocumentAction;
use App\Modules\Documents\Domain\Enums\DocumentType;
use App\Modules\Documents\Infrastructure\Persistence\Models\GeneratedDocument;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OrderDocumentsPanel extends Component
{
    public int $serviceOrderId;

    public function generateInvoice(GenerateWorkshopDocumentAction $action): void
    {
        $action->execute(DocumentType::INVOICE, $this->order(), auth()->id());
        session()->flash('success', 'Рахунок сформовано.');
    }

    public function generateIntakeAct(GenerateWorkshopDocumentAction $action): void
    {
        $action->execute(DocumentType::REPAIR_INTAKE_ACT, $this->order(), auth()->id());
        session()->flash('success', 'Акт приймання-передачі в ремонт сформовано.');
    }

    public function generateCompletionAct(GenerateWorkshopDocumentAction $action): void
    {
        $action->execute(DocumentType::COMPLETION_ACT, $this->order(), auth()->id());
        session()->flash('success', 'Акт виконаних робіт сформовано.');
    }

    public function render(): View
    {
        return view('livewire.documents.order-documents-panel', [
            'documents' => GeneratedDocument::query()->where('service_order_id', $this->serviceOrderId)->latest('id')->get(),
        ]);
    }

    private function order(): ServiceOrder
    {
        return ServiceOrder::query()->with(['client','items','payments'])->findOrFail($this->serviceOrderId);
    }
}
