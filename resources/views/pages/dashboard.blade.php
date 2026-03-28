@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Operational overview for the workshop.')

@section('content')
    <livewire:dashboard.dashboard-stats />
@endsection
