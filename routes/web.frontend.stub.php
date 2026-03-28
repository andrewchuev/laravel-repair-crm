<?php

use App\Modules\Clients\Infrastructure\Persistence\Models\Client;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'set-locale', 'active-user'])
    ->prefix('app')
    ->name('app.')
    ->group(function (): void {
        Route::view('/dashboard', 'pages.dashboard')->name('dashboard');
        Route::view('/profile', 'pages.profile')->name('profile');

        Route::view('/clients', 'pages.clients.index')->name('clients.index');
        Route::view('/clients/create', 'pages.clients.create')->name('clients.create');
        Route::get('/clients/{client}/edit', function (Client $client) {
            return view('pages.clients.edit', compact('client'));
        })->name('clients.edit');

        Route::view('/service-orders', 'pages.service-orders.index')->name('service-orders.index');
        Route::view('/service-orders/create', 'pages.service-orders.create')->name('service-orders.create');
        Route::get('/service-orders/{serviceOrder}', function (ServiceOrder $serviceOrder) {
            return view('pages.service-orders.show', compact('serviceOrder'));
        })->name('service-orders.show');
        Route::get('/service-orders/{serviceOrder}/documents', function (ServiceOrder $serviceOrder) {
            return view('pages.service-orders.documents', compact('serviceOrder'));
        })->name('service-orders.documents');

        Route::view('/settings/business', 'pages.settings.business')->name('settings.business');
        Route::view('/settings/bank-accounts', 'pages.settings.bank-accounts')->name('settings.bank-accounts');
        Route::view('/settings/documents', 'pages.settings.documents')->name('settings.documents');

        Route::get('/documents/{generatedDocument}/html', [\App\Modules\Documents\Presentation\Http\Controllers\DocumentDownloadController::class, 'html'])
            ->name('documents.html');
        Route::get('/documents/{generatedDocument}/pdf', [\App\Modules\Documents\Presentation\Http\Controllers\DocumentDownloadController::class, 'pdf'])
            ->name('documents.pdf');
    });
