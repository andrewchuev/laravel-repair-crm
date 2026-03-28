@extends('layouts.app')

@section('title', 'Edit Client')
@section('subtitle', 'Update customer information.')

@section('content')
    <livewire:clients.client-form :client-id="$client->id" />
@endsection
