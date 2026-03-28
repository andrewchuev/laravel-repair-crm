<?php

namespace App\Modules\Settings\Application\Actions;

use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use App\Modules\Settings\Infrastructure\Persistence\Models\DocumentSetting;

class SaveDocumentSettingAction
{
    public function execute(BusinessProfile $profile, array $data): DocumentSetting
    {
        $setting = DocumentSetting::query()->firstOrNew(['business_profile_id' => $profile->id]);
        $setting->fill($data);
        $setting->business_profile_id = $profile->id;
        $setting->save();

        return $setting->fresh();
    }
}
