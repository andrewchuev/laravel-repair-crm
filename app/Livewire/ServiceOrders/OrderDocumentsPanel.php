<?php

namespace App\Livewire\ServiceOrders;

use App\Modules\Documents\Application\Actions\GenerateCompletionActAction;
use App\Modules\Documents\Application\Actions\GenerateIntakeActAction;
use App\Modules\Documents\Application\Actions\GenerateInvoiceAction;
use App\Modules\Documents\Application\Actions\VoidGeneratedDocumentAction;
use App\Modules\Documents\Infrastructure\Persistence\Models\GeneratedDocument;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OrderDocumentsPanel extends Component
{
    public int $serviceOrderId;

    public function generateInvoice(GenerateInvoiceAction $action): void
    {
        $action->execute($this->order(), auth()->id());
        session()->flash('success', 'Invoice generated successfully.');
        $this->dispatch('toast', type: 'success', message: 'Invoice generated successfully.');
    }

    public function generateIntakeAct(GenerateIntakeActAction $action): void
    {
        $action->execute($this->order(), auth()->id());
        session()->flash('success', 'Intake act generated successfully.');
        $this->dispatch('toast', type: 'success', message: 'Intake act generated successfully.');
    }

    public function generateCompletionAct(GenerateCompletionActAction $action): void
    {
        $action->execute($this->order(), auth()->id());
        session()->flash('success', 'Completion act generated successfully.');
        $this->dispatch('toast', type: 'success', message: 'Completion act generated successfully.');
    }

    public function voidDocument(int $documentId, VoidGeneratedDocumentAction $action): void
    {
        $document = GeneratedDocument::query()->where('service_order_id', $this->serviceOrderId)->findOrFail($documentId);
        $action->execute($document, auth()->id(), 'Voided from UI');
        session()->flash('success', 'Document voided successfully.');
        $this->dispatch('toast', type: 'success', message: 'Document voided successfully.');
    }

    public function render(): View
    {
        $order = $this->order()->load('client');
        $documents = GeneratedDocument::query()->where('service_order_id', $order->id)->latest('id')->get();

        return view('livewire.service-orders.order-documents-panel', [
            'order' => $order,
            'documents' => $documents,
        ]);
    }

    private function order(): ServiceOrder
    {
        return ServiceOrder::query()->findOrFail($this->serviceOrderId);
    }
}
