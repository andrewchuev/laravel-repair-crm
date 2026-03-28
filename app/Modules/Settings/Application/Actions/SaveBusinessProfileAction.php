<?php

namespace App\Modules\Settings\Application\Actions;

use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;

class SaveBusinessProfileAction
{
    public function execute(array $data): BusinessProfile
    {
        $profile = BusinessProfile::query()->first();

        if (! $profile) {
            $data['is_active'] = true;
            return BusinessProfile::query()->create($data);
        }

        $profile->fill($data);
        $profile->save();

        return $profile->fresh();
    }
}
