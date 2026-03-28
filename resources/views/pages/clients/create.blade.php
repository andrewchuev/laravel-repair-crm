@extends('layouts.app')

@section('title', 'Create Client')
@section('subtitle', 'Add a new person or company to the CRM.')

@section('content')
    <livewire:clients.client-form />
@endsection
