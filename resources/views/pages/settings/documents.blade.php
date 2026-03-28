@extends('layouts.app')

@section('title', __('settings.documents.title'))
@section('subtitle', __('settings.documents.subtitle'))

@section('content')
    <x-flash-toast-stack />
    <livewire:settings.document-preferences-form />
@endsection
