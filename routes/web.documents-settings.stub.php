<?php

use App\Modules\Documents\Presentation\Http\Controllers\GeneratedDocumentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'set-locale', 'active-user'])->prefix('app/settings')->name('app.settings.')->group(function (): void {
    Route::view('/business', 'pages.settings.business')->name('business');
    Route::view('/bank-accounts', 'pages.settings.bank-accounts')->name('bank-accounts');
    Route::view('/documents', 'pages.settings.documents')->name('documents');
});

Route::middleware(['auth', 'set-locale', 'active-user'])->prefix('app/documents')->name('app.documents.')->group(function (): void {
    Route::get('/{generatedDocument}/download', [GeneratedDocumentController::class, 'download'])->name('download');
});
