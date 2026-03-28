<?php

use App\Modules\ServiceOrders\Presentation\Http\Controllers\ServiceOrderAttachmentController;
use App\Modules\ServiceOrders\Presentation\Http\Controllers\ServiceOrderCommentController;
use App\Modules\ServiceOrders\Presentation\Http\Controllers\ServiceOrderController;
use App\Modules\ServiceOrders\Presentation\Http\Controllers\ServiceOrderItemController;
use App\Modules\ServiceOrders\Presentation\Http\Controllers\ServiceOrderPaymentController;
use App\Modules\ServiceOrders\Presentation\Http\Controllers\ServiceOrderStatusController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'set-locale', 'active-user'])
    ->prefix('service-orders')
    ->name('service-orders.')
    ->group(function (): void {
        Route::get('/', [ServiceOrderController::class, 'index'])->name('index');
        Route::post('/', [ServiceOrderController::class, 'store'])->name('store');
        Route::get('/{serviceOrder}', [ServiceOrderController::class, 'show'])->name('show');

        Route::post('/{serviceOrder}/status', [ServiceOrderStatusController::class, 'store'])->name('status.store');
        Route::post('/{serviceOrder}/items', [ServiceOrderItemController::class, 'store'])->name('items.store');
        Route::post('/{serviceOrder}/payments', [ServiceOrderPaymentController::class, 'store'])->name('payments.store');
        Route::post('/{serviceOrder}/comments', [ServiceOrderCommentController::class, 'store'])->name('comments.store');
        Route::post('/{serviceOrder}/attachments', [ServiceOrderAttachmentController::class, 'store'])->name('attachments.store');
    });
