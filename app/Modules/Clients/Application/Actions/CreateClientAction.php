<?php

namespace App\Modules\Clients\Application\Actions;

use App\Models\User;
use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\Clients\Infrastructure\Persistence\Models\Client;

class CreateClientAction
{
    public function __construct(
        private readonly LogActivityAction $logActivityAction,
    ) {
    }

    public function execute(array $data, User $actor): Client
    {
        $client = Client::create([
            ...$data,
            'created_by_user_id' => $actor->id,
        ]);

        $this->logActivityAction->execute(
            entityType: 'client',
            entityId: $client->id,
            action: 'client.created',
            user: $actor,
            newValues: $client->toArray(),
        );

        return $client;
    }
}
