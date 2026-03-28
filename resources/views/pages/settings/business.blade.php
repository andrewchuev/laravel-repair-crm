@extends('layouts.app')

@section('title', __('settings.business.title'))
@section('subtitle', __('settings.business.subtitle'))

@section('content')
    <x-flash-toast-stack />
    <livewire:settings.business-profile-form />
@endsection
