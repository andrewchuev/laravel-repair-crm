<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('app.dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->get('/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware(['auth', 'set-locale', 'active-user'])->get('/me', function (Request $request) {
    return response()->json([
        'data' => [
            'id' => $request->user()->id,
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'role' => $request->user()->role?->value ?? $request->user()->role,
            'preferred_locale' => $request->user()->preferred_locale?->value ?? $request->user()->preferred_locale,
            'is_active' => (bool) $request->user()->is_active,
        ],
    ]);
})->name('me');

require base_path('app/Modules/Clients/Presentation/Routes/web.php');
require base_path('app/Modules/ServiceOrders/Presentation/Routes/web.php');
require base_path('routes/web.frontend.stub.php');
require base_path('routes/web.documents-settings.stub.php');
