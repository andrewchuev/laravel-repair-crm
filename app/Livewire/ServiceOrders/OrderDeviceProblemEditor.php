<?php

namespace App\Livewire\ServiceOrders;

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OrderDeviceProblemEditor extends Component
{
    public int $serviceOrderId;

    public bool $isEditing = false;

    public string $category = '';
    public string $item_name = '';
    public string $brand = '';
    public string $model = '';
    public string $serial_number = '';
    public string $reported_problem = '';
    public string $intake_condition = '';
    public string $accessories = '';

    public function mount(int $serviceOrderId): void
    {
        $this->serviceOrderId = $serviceOrderId;
        $this->fillFromModel();
    }

    public function startEditing(): void
    {
        if (! $this->canEdit()) {
            $message = __('service_orders.device_editor.messages.locked');
            session()->flash('error', $message);
            $this->dispatch('toast', type: 'error', message: $message);

            return;
        }

        $this->fillFromModel();
        $this->resetValidation();
        $this->isEditing = true;
    }

    public function cancelEditing(): void
    {
        $this->fillFromModel();
        $this->resetValidation();
        $this->isEditing = false;
    }

    public function save(): void
    {
        if (! $this->canEdit()) {
            $message = __('service_orders.device_editor.messages.locked');
            session()->flash('error', $message);
            $this->dispatch('toast', type: 'error', message: $message);

            return;
        }

        $validated = $this->validate([
            'category' => ['required', 'in:laptop,desktop,printer,mfp,tablet,monitor,networking,cartridge,server,other'],
            'item_name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'reported_problem' => ['required', 'string', 'max:2000'],
            'intake_condition' => ['nullable', 'string', 'max:2000'],
            'accessories' => ['nullable', 'string', 'max:2000'],
        ]);

        $order = $this->order();
        $order->fill($validated);
        $order->save();

        $this->isEditing = false;

        $message = __('service_orders.device_editor.messages.saved');
        session()->flash('success', $message);

        $this->redirectRoute(
            'app.service-orders.show',
            ['serviceOrder' => $order->id],
            navigate: true
        );
    }

    public function render(): View
    {
        return view('livewire.service-orders.order-device-problem-editor', [
            'order' => $this->order(),
            'canEdit' => $this->canEdit(),
            'categories' => [
                'laptop',
                'desktop',
                'printer',
                'mfp',
                'tablet',
                'monitor',
                'networking',
                'cartridge',
                'server',
                'other',
            ],
        ]);
    }

    private function fillFromModel(): void
    {
        $order = $this->order();

        $this->category = $this->enumValue($order->category);
        $this->item_name = (string) ($order->item_name ?? '');
        $this->brand = (string) ($order->brand ?? '');
        $this->model = (string) ($order->model ?? '');
        $this->serial_number = (string) ($order->serial_number ?? '');
        $this->reported_problem = (string) ($order->reported_problem ?? '');
        $this->intake_condition = (string) ($order->intake_condition ?? '');
        $this->accessories = (string) ($order->accessories ?? '');
    }

    private function canEdit(): bool
    {
        $status = $this->enumValue($this->order()->status);
        $role = $this->enumValue(auth()->user()?->role);

        if ($status !== 'delivered') {
            return true;
        }

        return in_array($role, ['admin', 'manager'], true);
    }

    private function order(): ServiceOrder
    {
        return ServiceOrder::query()->findOrFail($this->serviceOrderId);
    }

    private function enumValue(mixed $value): string
    {
        if ($value instanceof \BackedEnum) {
            return (string) $value->value;
        }

        return (string) ($value ?? '');
    }
}
