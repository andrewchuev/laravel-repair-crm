@extends('layouts.app')

@section('title', __('settings.bank_accounts.title'))
@section('subtitle', __('settings.bank_accounts.subtitle'))

@section('content')
    <x-flash-toast-stack />
    <livewire:settings.bank-account-form />
@endsection
