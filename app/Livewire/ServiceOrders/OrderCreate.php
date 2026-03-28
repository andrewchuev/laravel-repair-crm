<?php

namespace App\Livewire\ServiceOrders;

use App\Modules\Clients\Infrastructure\Persistence\Models\Client;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrderStatusHistory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrderCreate extends Component
{
    public string $client_id = '';
    public string $priority = 'normal';
    public string $category = 'laptop';
    public string $item_name = '';
    public string $brand = '';
    public string $model = '';
    public string $serial_number = '';
    public string $reported_problem = '';
    public string $intake_condition = '';
    public string $accessories = '';
    public string $estimated_price = '0';
    public string $agreed_price = '0';
    public string $internal_notes = '';

    public function save()
    {
        $validated = $this->validate([
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'priority' => ['required', 'in:low,normal,high,urgent'],
            'category' => ['required', 'in:computer,laptop,printer,mfp,cartridge,monitor,network,other'],
            'item_name' => ['required', 'string', 'max:200'],
            'brand' => ['nullable', 'string', 'max:120'],
            'model' => ['nullable', 'string', 'max:120'],
            'serial_number' => ['nullable', 'string', 'max:120'],
            'reported_problem' => ['required', 'string', 'max:5000'],
            'intake_condition' => ['nullable', 'string', 'max:5000'],
            'accessories' => ['nullable', 'string', 'max:1000'],
            'estimated_price' => ['required', 'numeric', 'gte:0'],
            'agreed_price' => ['required', 'numeric', 'gte:0'],
            'internal_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $order = DB::transaction(function () use ($validated) {
            $order = ServiceOrder::query()->create([
                'order_number' => $this->nextOrderNumber(),
                'client_id' => (int) $validated['client_id'],
                'status' => 'new',
                'priority' => $validated['priority'],
                'category' => $validated['category'],
                'item_name' => $validated['item_name'],
                'brand' => $validated['brand'] ?: null,
                'model' => $validated['model'] ?: null,
                'serial_number' => $validated['serial_number'] ?: null,
                'reported_problem' => $validated['reported_problem'],
                'intake_condition' => $validated['intake_condition'] ?: null,
                'accessories' => $validated['accessories'] ?: null,
                'estimated_price' => (float) $validated['estimated_price'],
                'agreed_price' => (float) $validated['agreed_price'],
                'final_price' => 0,
                'paid_amount' => 0,
                'balance_amount' => 0,
                'internal_notes' => $validated['internal_notes'] ?: null,
                'received_at' => now(),
                'accepted_by_user_id' => auth()->id(),
            ]);

            ServiceOrderStatusHistory::query()->create([
                'service_order_id' => $order->id,
                'old_status' => null,
                'new_status' => 'new',
                'comment' => 'Order created via UI.',
                'changed_by_user_id' => auth()->id(),
                'created_at' => now(),
            ]);

            return $order;
        });

        session()->flash('success', 'Service order created successfully.');

        return redirect()->route('app.service-orders.show', $order->id);
    }

    public function render(): View
    {
        $clients = Client::query()
            ->orderBy('id')
            ->get();

        return view('livewire.service-orders.order-create', [
            'clients' => $clients,
            'priorities' => ['low', 'normal', 'high', 'urgent'],
            'categories' => ['computer', 'laptop', 'printer', 'mfp', 'cartridge', 'monitor', 'network', 'other'],
        ]);
    }

    private function nextOrderNumber(): string
    {
        $year = now()->format('Y');

        $last = ServiceOrder::query()
            ->where('order_number', 'like', 'RP-' . $year . '-%')
            ->orderByDesc('id')
            ->value('order_number');

        $next = 1;

        if (is_string($last) && preg_match('/RP-' . preg_quote($year, '/') . '-(\d+)/', $last, $matches)) {
            $next = ((int) $matches[1]) + 1;
        }

        return sprintf('RP-%s-%06d', $year, $next);
    }
}
