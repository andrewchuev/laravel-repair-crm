<?php

namespace App\Modules\ServiceOrders\Application\Actions;

use App\Models\User;
use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrderComment;

class AddServiceOrderCommentAction
{
    public function __construct(
        private readonly LogActivityAction $logActivityAction,
    ) {
    }

    public function execute(ServiceOrder $serviceOrder, array $data, User $actor): ServiceOrderComment
    {
        $comment = ServiceOrderComment::create([
            ...$data,
            'service_order_id' => $serviceOrder->id,
            'user_id' => $actor->id,
        ]);

        $this->logActivityAction->execute(
            entityType: 'service_order',
            entityId: $serviceOrder->id,
            action: 'service_order.comment_added',
            user: $actor,
            newValues: $comment->toArray(),
        );

        return $comment->refresh();
    }
}
