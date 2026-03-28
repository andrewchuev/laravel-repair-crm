<?php

namespace App\Modules\Activity\Application\Actions;

use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;
use Illuminate\Contracts\Auth\Authenticatable;

class LogActivityAction
{
    public function execute(
        string $entityType,
        int $entityId,
        string $action,
        ?Authenticatable $user = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        array $context = []
    ): ActivityLog {
        return ActivityLog::create([
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'action' => $action,
            'user_id' => $user?->getAuthIdentifier(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'context' => $context,
            'created_at' => now(),
        ]);
    }
}
