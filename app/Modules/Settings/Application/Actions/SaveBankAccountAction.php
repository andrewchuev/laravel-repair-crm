<?php

namespace App\Modules\Settings\Application\Actions;

use App\Modules\Settings\Infrastructure\Persistence\Models\BankAccount;
use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use Illuminate\Support\Facades\DB;

class SaveBankAccountAction
{
    public function execute(BusinessProfile $profile, array $data): BankAccount
    {
        return DB::transaction(function () use ($profile, $data) {
            if (($data['is_default'] ?? false) === true) {
                BankAccount::query()->where('business_profile_id', $profile->id)->update(['is_default' => false]);
            }

            $account = BankAccount::query()->firstOrNew([
                'business_profile_id' => $profile->id,
                'is_default' => true,
            ]);

            $account->fill($data);
            $account->business_profile_id = $profile->id;
            $account->save();

            return $account->fresh();
        });
    }
}
