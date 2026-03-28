<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ServiceOrders\Application\Actions\RecordPaymentAction;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Presentation\Http\Requests\StorePaymentRequest;
use App\Modules\ServiceOrders\Presentation\Http\Resources\PaymentResource;

class ServiceOrderPaymentController extends Controller
{
    public function store(
        StorePaymentRequest $request,
        ServiceOrder $serviceOrder,
        RecordPaymentAction $action
    ): PaymentResource {
        $payment = $action->execute($serviceOrder, $request->validated(), $request->user());

        return new PaymentResource($payment);
    }
}
