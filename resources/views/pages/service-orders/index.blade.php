@extends('layouts.app')

@section('title', 'Service Orders')
@section('subtitle', 'Track active, ready, and completed work.')

@section('content')
    <livewire:service-orders.order-index />
@endsection
