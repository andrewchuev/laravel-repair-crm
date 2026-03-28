<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ServiceOrders\Application\Actions\CreateServiceOrderAction;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Presentation\Http\Requests\StoreServiceOrderRequest;
use App\Modules\ServiceOrders\Presentation\Http\Resources\ServiceOrderDetailResource;
use App\Modules\ServiceOrders\Presentation\Http\Resources\ServiceOrderListResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ServiceOrderController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $orders = ServiceOrder::query()
            ->with(['client', 'assignedMaster'])
            ->latest('received_at')
            ->paginate(20);

        return ServiceOrderListResource::collection($orders);
    }

    public function store(StoreServiceOrderRequest $request, CreateServiceOrderAction $action): ServiceOrderDetailResource
    {
        $serviceOrder = $action->execute($request->validated(), $request->user());

        $serviceOrder->load(['client', 'acceptedBy', 'assignedMaster', 'items', 'payments', 'comments.user', 'attachments', 'statusHistory.changedBy']);

        return new ServiceOrderDetailResource($serviceOrder);
    }

    public function show(ServiceOrder $serviceOrder): ServiceOrderDetailResource
    {
        $serviceOrder->load(['client', 'acceptedBy', 'assignedMaster', 'items', 'payments', 'comments.user', 'attachments', 'statusHistory.changedBy']);

        return new ServiceOrderDetailResource($serviceOrder);
    }
}
