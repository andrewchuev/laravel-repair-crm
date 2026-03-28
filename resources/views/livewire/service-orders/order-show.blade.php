<div class="space-y-6">
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ $order->order_number }}</h2>
                    <x-status-badge :status="$order->status->value ?? $order->status" />
                </div>

                <div class="mt-2 text-sm text-slate-500">
                    {{ $order->item_name }} · {{ $order->brand ?: '—' }} {{ $order->model ?: '' }}
                </div>

                <div class="mt-4 flex flex-wrap gap-2">
                    @if ($order->serial_number)
                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">
                            {{ __('service_orders.fields.serial_number') }}: {{ $order->serial_number }}
                        </span>
                    @endif

                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">
                        {{ __('service_orders.category.' . ($order->category->value ?? $order->category)) }}
                    </span>

                    @if ($order->assignedMaster?->name)
                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">
                            {{ __('service_orders.fields.assigned_master') }}: {{ $order->assignedMaster->name }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid gap-3 sm:grid-cols-3">
                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                    <div class="text-xs uppercase tracking-wide text-slate-500">{{ __('service_orders.fields.final_price') }}</div>
                    <div class="mt-1 text-lg font-semibold"><x-money :amount="$order->final_price" /></div>
                </div>

                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                    <div class="text-xs uppercase tracking-wide text-slate-500">{{ __('service_orders.fields.paid_amount') }}</div>
                    <div class="mt-1 text-lg font-semibold"><x-money :amount="$order->paid_amount" /></div>
                </div>

                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                    <div class="text-xs uppercase tracking-wide text-slate-500">{{ __('service_orders.fields.balance_amount') }}</div>
                    <div class="mt-1 text-lg font-semibold"><x-money :amount="$order->balance_amount" /></div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.3fr_1fr]">
        <div class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold tracking-tight text-slate-900">{{ __('service_orders.sections.client') }}</h3>
                <dl class="mt-4 grid gap-4 md:grid-cols-2">
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('service_orders.fields.client') }}</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $order->client?->display_name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('clients.fields.phone') }}</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $order->client?->phone ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('clients.fields.email') }}</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $order->client?->email ?: '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('service_orders.fields.received_at') }}</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ optional($order->received_at)->format('d.m.Y H:i') }}</dd>
                    </div>
                </dl>
            </div>

            <livewire:service-orders.order-device-problem-editor
                :service-order-id="$order->id"
                :key="'device-problem-'.$order->id"
            />

            <livewire:service-orders.order-item-list :service-order-id="$order->id" :key="'order-items-'.$order->id" />
            <livewire:service-orders.order-item-form :service-order-id="$order->id" :key="'order-item-form-'.$order->id" />

            <livewire:service-orders.payment-list :service-order-id="$order->id" :key="'payments-'.$order->id" />
            <livewire:service-orders.payment-form :service-order-id="$order->id" :key="'payment-form-'.$order->id" />
        </div>

        <div class="space-y-6">
            <livewire:service-orders.order-status-changer :service-order-id="$order->id" :key="'status-'.$order->id" />

            <livewire:service-orders.comment-list :service-order-id="$order->id" :key="'comments-'.$order->id" />
            <livewire:service-orders.comment-form :service-order-id="$order->id" :key="'comment-form-'.$order->id" />

            <livewire:service-orders.attachment-gallery :service-order-id="$order->id" :key="'attachment-gallery-'.$order->id" />
            <livewire:service-orders.attachment-upload :service-order-id="$order->id" :key="'attachment-upload-'.$order->id" />

            <livewire:service-orders.status-history-timeline :service-order-id="$order->id" :key="'status-history-'.$order->id" />
        </div>
    </div>
</div>
