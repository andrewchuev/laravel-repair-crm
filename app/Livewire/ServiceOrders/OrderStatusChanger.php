<?php

namespace App\Livewire\ServiceOrders;

use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderStatus;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrderStatusHistory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrderStatusChanger extends Component
{
    public int $serviceOrderId;
    public string $status = '';
    public string $comment = '';
    public ?string $successMessage = null;
    public ?string $errorMessage = null;

    public function mount(int $serviceOrderId): void
    {
        $this->serviceOrderId = $serviceOrderId;
        $order = $this->order();
        $this->status = (string) ($order->status->value ?? $order->status);
    }

    public function save(): void
    {
        $this->resetMessages();

        $this->validate([
            'status' => ['required', 'string'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $order = $this->order();
        $current = (string) ($order->status->value ?? $order->status);

        if ($current === $this->status) {
            $this->errorMessage = 'Select a different status first.';
            return;
        }

        $allowed = $this->allowedTransitions()[$current] ?? [];

        if (! in_array($this->status, $allowed, true)) {
            $this->errorMessage = 'This status transition is not allowed.';
            return;
        }

        DB::transaction(function () use ($order, $current): void {
            $newStatus = ServiceOrderStatus::from($this->status);

            $order->status = $newStatus;
            $this->applyStatusTimestamps($order, $this->status);
            $order->save();

            ServiceOrderStatusHistory::query()->create([
                'service_order_id' => $order->id,
                'old_status' => $current,
                'new_status' => $newStatus->value,
                'comment' => $this->comment ?: null,
                'changed_by_user_id' => auth()->id(),
                'created_at' => now(),
            ]);
        });

        $this->successMessage = 'Status updated successfully.';
        $this->comment = '';

        $this->dispatch('service-order-updated');
    }

    public function render(): View
    {
        $order = $this->order();
        $current = (string) ($order->status->value ?? $order->status);

        return view('livewire.service-orders.order-status-changer', [
            'order' => $order,
            'currentStatus' => $current,
            'nextStatuses' => $this->allowedTransitions()[$current] ?? [],
        ]);
    }

    private function order(): ServiceOrder
    {
        return ServiceOrder::query()->findOrFail($this->serviceOrderId);
    }

    private function resetMessages(): void
    {
        $this->successMessage = null;
        $this->errorMessage = null;
    }

    private function allowedTransitions(): array
    {
        return [
            'new' => ['diagnostics', 'cancelled'],
            'diagnostics' => ['awaiting_approval', 'approved', 'cancelled'],
            'awaiting_approval' => ['approved', 'cancelled'],
            'approved' => ['in_progress', 'waiting_parts', 'cancelled'],
            'in_progress' => ['waiting_parts', 'ready', 'cancelled'],
            'waiting_parts' => ['in_progress', 'ready', 'cancelled'],
            'ready' => ['delivered'],
            'delivered' => [],
            'cancelled' => [],
        ];
    }

    private function applyStatusTimestamps(ServiceOrder $order, string $status): void
    {
        $now = Carbon::now();

        match ($status) {
            'approved' => $order->approved_at = $now,
            'ready' => $order->ready_at = $now,
            'delivered' => $order->delivered_at = $now,
            'cancelled' => $order->cancelled_at = $now,
            default => null,
        };
    }
}
