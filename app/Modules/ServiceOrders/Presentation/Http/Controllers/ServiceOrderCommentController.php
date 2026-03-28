<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ServiceOrders\Application\Actions\AddServiceOrderCommentAction;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Presentation\Http\Requests\StoreServiceOrderCommentRequest;
use App\Modules\ServiceOrders\Presentation\Http\Resources\ServiceOrderCommentResource;

class ServiceOrderCommentController extends Controller
{
    public function store(
        StoreServiceOrderCommentRequest $request,
        ServiceOrder $serviceOrder,
        AddServiceOrderCommentAction $action
    ): ServiceOrderCommentResource {
        $comment = $action->execute($serviceOrder, $request->validated(), $request->user());

        return new ServiceOrderCommentResource($comment->load('user'));
    }
}
