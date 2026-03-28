<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ($pageTitle ?? trim($__env->yieldContent('title'))) ? (($pageTitle ?? trim($__env->yieldContent('title'))) . ' · Repair CRM') : 'Repair CRM' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
        @include('layouts.partials.sidebar')

        <div class="min-w-0">
            @include('layouts.partials.topbar')

            <main class="p-4 sm:p-6 lg:p-8">
                @include('layouts.partials.flash')
                @yield('content')
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
