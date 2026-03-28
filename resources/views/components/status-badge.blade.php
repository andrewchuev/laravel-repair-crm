@props(['status'])

@php
    $map = [
        'new' => 'bg-slate-100 text-slate-700',
        'diagnostics' => 'bg-blue-100 text-blue-700',
        'awaiting_approval' => 'bg-amber-100 text-amber-700',
        'approved' => 'bg-indigo-100 text-indigo-700',
        'in_progress' => 'bg-violet-100 text-violet-700',
        'waiting_parts' => 'bg-orange-100 text-orange-700',
        'ready' => 'bg-emerald-100 text-emerald-700',
        'delivered' => 'bg-slate-200 text-slate-700',
        'cancelled' => 'bg-rose-100 text-rose-700',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex rounded-full px-2.5 py-1 text-xs font-medium ' . ($map[$status] ?? 'bg-slate-100 text-slate-700')]) }}>
    {{ __('service_orders.status.' . $status) }}
</span>
