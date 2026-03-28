@extends('layouts.app')

@section('title', __('profile.title'))
@section('subtitle', __('profile.subtitle'))

@section('content')
    <x-flash-toast-stack />
    <livewire:profile.profile-settings-form />
@endsection
