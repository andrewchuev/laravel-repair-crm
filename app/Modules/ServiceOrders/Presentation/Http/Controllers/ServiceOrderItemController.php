<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ServiceOrders\Application\Actions\AddServiceOrderItemAction;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Presentation\Http\Requests\StoreServiceOrderItemRequest;
use App\Modules\ServiceOrders\Presentation\Http\Resources\ServiceOrderItemResource;

class ServiceOrderItemController extends Controller
{
    public function store(
        StoreServiceOrderItemRequest $request,
        ServiceOrder $serviceOrder,
        AddServiceOrderItemAction $action
    ): ServiceOrderItemResource {
        $item = $action->execute($serviceOrder, $request->validated(), $request->user());

        return new ServiceOrderItemResource($item);
    }
}
