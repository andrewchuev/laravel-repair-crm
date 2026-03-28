<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ServiceOrders\Application\Actions\ChangeServiceOrderStatusAction;
use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderStatus;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Presentation\Http\Requests\ChangeServiceOrderStatusRequest;
use App\Modules\ServiceOrders\Presentation\Http\Resources\ServiceOrderDetailResource;

class ServiceOrderStatusController extends Controller
{
    public function store(
        ChangeServiceOrderStatusRequest $request,
        ServiceOrder $serviceOrder,
        ChangeServiceOrderStatusAction $action
    ): ServiceOrderDetailResource {
        $serviceOrder = $action->execute(
            serviceOrder: $serviceOrder,
            newStatus: ServiceOrderStatus::from($request->validated('status')),
            actor: $request->user(),
            comment: $request->validated('comment'),
        );

        $serviceOrder->load(['client', 'acceptedBy', 'assignedMaster', 'items', 'payments', 'comments.user', 'attachments', 'statusHistory.changedBy']);

        return new ServiceOrderDetailResource($serviceOrder);
    }
}
