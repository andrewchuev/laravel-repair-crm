<?php

namespace App\Livewire\Dashboard;

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DashboardStats extends Component
{
    public function render(): View
    {
        $stats = [
            'active' => ServiceOrder::query()->whereNotIn('status', ['delivered', 'cancelled'])->count(),
            'diagnostics' => ServiceOrder::query()->where('status', 'diagnostics')->count(),
            'awaiting_approval' => ServiceOrder::query()->where('status', 'awaiting_approval')->count(),
            'waiting_parts' => ServiceOrder::query()->where('status', 'waiting_parts')->count(),
            'ready' => ServiceOrder::query()->where('status', 'ready')->count(),
        ];

        $recentOrders = ServiceOrder::query()
            ->with('client')
            ->latest('received_at')
            ->limit(10)
            ->get();

        return view('livewire.dashboard.dashboard-stats', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
        ]);
    }
}
