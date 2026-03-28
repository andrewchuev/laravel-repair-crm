<?php

namespace Database\Seeders;

use App\Modules\Settings\Infrastructure\Persistence\Models\BankAccount;
use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use App\Modules\Settings\Infrastructure\Persistence\Models\DocumentPreference;
use Illuminate\Database\Seeder;

class BusinessProfileAndDocumentsSeeder extends Seeder
{
    public function run(): void
    {
        $profile = BusinessProfile::query()->updateOrCreate(
            ['tax_id' => '3073520397'],
            ['legal_type' => 'fop', 'full_name_uk' => 'ФОП Чуєв Андрій Андрійович', 'tax_id' => '3073520397', 'registration_address_uk' => 'Україна, 69020, Запорізька обл., місто Запоріжжя, вул. Перемоги, будинок 105, квартира 44', 'default_locale' => 'uk', 'signer_name_uk' => 'Чуєв Андрій Андрійович', 'signer_title_uk' => 'ФОП', 'is_active' => true]
        );
        BankAccount::query()->updateOrCreate(
            ['business_profile_id' => $profile->id, 'iban' => 'UA573220010000026000330070181'],
            ['name_uk' => 'Основний рахунок', 'recipient_name_uk' => 'ФОП Чуєв Андрій Андрійович', 'iban' => 'UA573220010000026000330070181', 'bank_name_uk' => 'Акціонерне Товариство УНІВЕРСАЛ БАНК', 'bank_mfo' => '322001', 'bank_edrpou' => '21133352', 'payment_purpose_template_uk' => 'Призначення платежу вказується згідно з актом виконаних робіт, інвойсом або контрактом.', 'is_default' => true]
        );
        DocumentPreference::query()->updateOrCreate(
            ['business_profile_id' => $profile->id],
            ['invoice_prefix' => 'INV', 'intake_act_prefix' => 'RIN', 'completion_act_prefix' => 'ACT', 'default_document_locale' => 'uk', 'repair_terms_uk' => 'Замовник погоджується з проведенням діагностики та ремонту в межах погодженого замовлення. Додаткові роботи виконуються після окремого погодження.', 'storage_terms_uk' => 'Після повідомлення про готовність техніка підлягає отриманню замовником у розумний строк. Умови довгострокового зберігання можуть узгоджуватися окремо.', 'diagnostic_terms_uk' => 'Діагностика може бути платною, якщо замовник відмовляється від подальшого ремонту або якщо це передбачено умовами замовлення.', 'warranty_terms_uk' => 'Гарантія поширюється лише на виконані роботи та встановлені деталі за умови дотримання правил експлуатації.', 'invoice_footer_uk' => 'Оплата рахунку підтверджує згоду замовника з обсягом і вартістю робіт.', 'completion_act_footer_uk' => 'Підписання акту підтверджує відсутність претензій до обсягу та якості виконаних робіт на момент передачі.']
        );
    }
}
