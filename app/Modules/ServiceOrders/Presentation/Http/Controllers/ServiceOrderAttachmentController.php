<?php

namespace App\Modules\ServiceOrders\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ServiceOrders\Application\Actions\UploadServiceOrderAttachmentAction;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Presentation\Http\Requests\StoreServiceOrderAttachmentRequest;
use App\Modules\ServiceOrders\Presentation\Http\Resources\ServiceOrderAttachmentResource;

class ServiceOrderAttachmentController extends Controller
{
    public function store(
        StoreServiceOrderAttachmentRequest $request,
        ServiceOrder $serviceOrder,
        UploadServiceOrderAttachmentAction $action
    ): ServiceOrderAttachmentResource {
        $attachment = $action->execute(
            serviceOrder: $serviceOrder,
            file: $request->file('file'),
            data: $request->validated(),
            actor: $request->user(),
        );

        return new ServiceOrderAttachmentResource($attachment);
    }
}
