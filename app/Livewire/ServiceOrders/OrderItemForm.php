<?php

namespace App\Livewire\ServiceOrders;

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrderItem;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrderItemForm extends Component
{
    public int $serviceOrderId;

    public string $type = 'work';
    public string $name = '';
    public string $description = '';
    public string $quantity = '1';
    public string $unit_price = '0';
    public string $cost_price = '0';
    public string $position = '1';

    public function save(): void
    {
        $validated = $this->validate([
            'type' => ['required', 'in:work,part'],
            'name' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'numeric', 'gt:0'],
            'unit_price' => ['required', 'numeric', 'gte:0'],
            'cost_price' => ['required', 'numeric', 'gte:0'],
            'position' => ['required', 'integer', 'gte:1'],
        ]);

        $order = $this->order();

        DB::transaction(function () use ($order, $validated): void {
            ServiceOrderItem::query()->create([
                'service_order_id' => $order->id,
                'type' => $validated['type'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?: null,
                'quantity' => (float) $validated['quantity'],
                'unit_price' => (float) $validated['unit_price'],
                'cost_price' => (float) $validated['cost_price'],
                'total_price' => (float) $validated['quantity'] * (float) $validated['unit_price'],
                'position' => (int) $validated['position'],
                'created_by_user_id' => auth()->id(),
            ]);

            $this->recalculateTotals($order->fresh());
        });

        $this->resetForm();
        $this->dispatch('service-order-updated');
    }

    public function render(): View
    {
        return view('livewire.service-orders.order-item-form');
    }

    private function order(): ServiceOrder
    {
        return ServiceOrder::query()->findOrFail($this->serviceOrderId);
    }

    private function recalculateTotals(ServiceOrder $order): void
    {
        $final = (float) $order->items()->sum('total_price');
        $paid = (float) $order->paid_amount;

        $order->final_price = $final;
        $order->balance_amount = max($final - $paid, 0);
        $order->save();
    }

    private function resetForm(): void
    {
        $this->type = 'work';
        $this->name = '';
        $this->description = '';
        $this->quantity = '1';
        $this->unit_price = '0';
        $this->cost_price = '0';
        $this->position = '1';
    }
}
