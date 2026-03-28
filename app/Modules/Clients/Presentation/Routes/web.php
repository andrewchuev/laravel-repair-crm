<?php

use App\Modules\Clients\Presentation\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'set-locale', 'active-user'])
    ->prefix('clients')
    ->name('clients.')
    ->group(function (): void {
        Route::get('/', [ClientController::class, 'index'])->name('index');
        Route::post('/', [ClientController::class, 'store'])->name('store');
        Route::get('/{client}', [ClientController::class, 'show'])->name('show');
    });
