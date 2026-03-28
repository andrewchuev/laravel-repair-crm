<?php

namespace Database\Seeders;

use App\Modules\Settings\Infrastructure\Persistence\Models\BankAccount;
use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use App\Modules\Settings\Infrastructure\Persistence\Models\DocumentSetting;
use Illuminate\Database\Seeder;

class WorkshopBusinessSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $profile = BusinessProfile::query()->updateOrCreate(
            ['tax_id' => '3073520397'],
            [
                'legal_name' => 'ФОП Чуєв Андрій Андрійович',
                'short_name' => 'ФОП Чуєв А.А.',
                'default_locale' => 'uk',
                'signer_name' => 'Чуєв Андрій Андрійович',
                'signer_title' => 'ФОП',
                'is_active' => true,
            ]
        );

        BankAccount::query()->updateOrCreate(
            ['iban' => 'UA573220010000026000330070181'],
            [
                'business_profile_id' => $profile->id,
                'title' => 'Основний рахунок',
                'recipient' => 'ФОП Чуєв Андрій Андрійович',
                'bank_name' => 'Акціонерне Товариство УНІВЕРСАЛ БАНК',
                'bank_mfo' => '322001',
                'bank_edrpou' => '21133352',
                'currency' => 'UAH',
                'payment_purpose_template' => 'Призначення платежу вказується згідно з актом виконаних робіт, інвойсом або контрактом.',
                'is_default' => true,
                'is_active' => true,
            ]
        );

        DocumentSetting::query()->updateOrCreate(
            ['business_profile_id' => $profile->id],
            [
                'document_locale' => 'uk',
                'invoice_prefix' => 'РХ',
                'intake_act_prefix' => 'АР',
                'completion_act_prefix' => 'АВР',
                'warranty_prefix' => 'ГТ',
                'number_format' => '{prefix}-{year}-{seq}',
                'default_city' => 'Запоріжжя',
                'invoice_footer' => 'Оплата здійснюється згідно з реквізитами, зазначеними у рахунку.',
                'intake_terms' => 'Пристрій приймається в ремонт / діагностику згідно з умовами майстерні.',
                'completion_terms' => 'Підписання акта підтверджує прийняття виконаних робіт.',
                'warranty_terms' => 'Гарантія на виконані роботи діє відповідно до умов майстерні.',
                'storage_terms' => 'Невитребувана техніка зберігається на умовах майстерні.',
            ]
        );
    }
}
