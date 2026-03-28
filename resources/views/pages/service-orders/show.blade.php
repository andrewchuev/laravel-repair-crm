@extends('layouts.app')

@section('title', __('service_orders.show.title'))
@section('subtitle', __('service_orders.show.subtitle'))

@section('content')
    <x-flash-toast-stack />

    <div class="mb-6 flex justify-end">
        <a href="{{ route('app.service-orders.documents', $serviceOrder->id) }}"
           class="inline-flex cursor-pointer items-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
            {{ __('service_orders.show.documents_button') }}
        </a>
    </div>

    <livewire:service-orders.order-show :service-order-id="$serviceOrder->id" />
@endsection
