@extends('layouts.app')

@section('title', __('documents.page.title'))
@section('subtitle', __('documents.page.subtitle'))

@section('content')
    <x-flash-toast-stack />
    <livewire:service-orders.order-documents-panel :service-order-id="$serviceOrder->id" />
@endsection
