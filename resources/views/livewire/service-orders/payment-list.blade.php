<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-4 flex items-center justify-between gap-3">
        <h3 class="text-lg font-semibold tracking-tight text-slate-900">{{ __('service_orders.sections.payments') }}</h3>
        <div class="text-sm text-slate-500">
            {{ __('service_orders.fields.paid_amount') }}: <x-money :amount="$order->paid_amount" /> · {{ __('service_orders.fields.balance_amount') }}: <x-money :amount="$order->balance_amount" />
        </div>
    </div>

    @if ($payments->isEmpty())
        <x-empty-state :title="__('service_orders.empty.payments_title')" :description="__('service_orders.empty.payments_description')" />
    @else
        <div class="space-y-3">
            @foreach ($payments as $payment)
                @php
                    $type = $payment->type->value ?? $payment->type;
                    $method = $payment->method->value ?? $payment->method;
                @endphp
                <div class="flex items-start justify-between rounded-2xl border border-slate-200 px-4 py-3">
                    <div>
                        <div class="text-sm font-medium text-slate-900">
                            {{ __('payments.types.' . $type) }} · {{ __('payments.methods.' . $method) }}
                        </div>
                        <div class="mt-1 text-xs text-slate-500">
                            {{ optional($payment->paid_at)->format('d.m.Y H:i') }} · {{ $payment->comment ?: __('payments.messages.no_comment') }}
                        </div>
                    </div>

                    <div class="text-sm font-semibold text-slate-900">
                        <x-money :amount="$payment->amount" />
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
