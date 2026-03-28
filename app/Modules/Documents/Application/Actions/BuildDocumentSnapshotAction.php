<?php

namespace App\Modules\Documents\Application\Actions;

use App\Modules\Documents\Domain\Enums\DocumentType;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\Settings\Infrastructure\Persistence\Models\BankAccount;
use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;
use App\Modules\Settings\Infrastructure\Persistence\Models\DocumentPreference;

class BuildDocumentSnapshotAction
{
    public function execute(DocumentType $type, ServiceOrder $order, BusinessProfile $profile, ?BankAccount $bankAccount, DocumentPreference $preferences, string $number): array
    {
        $order->loadMissing(['client', 'items', 'payments']);
        return [
            'document' => ['type' => $type->value, 'number' => $number, 'date' => now()->toDateString(), 'locale' => 'uk'],
            'business' => ['full_name_uk' => $profile->full_name_uk, 'tax_id' => $profile->tax_id, 'registration_address_uk' => $profile->registration_address_uk, 'phone' => $profile->phone, 'email' => $profile->email, 'signer_name_uk' => $profile->signer_name_uk, 'signer_title_uk' => $profile->signer_title_uk],
            'bank_account' => $bankAccount ? ['recipient_name_uk' => $bankAccount->recipient_name_uk, 'iban' => $bankAccount->iban, 'bank_name_uk' => $bankAccount->bank_name_uk, 'bank_mfo' => $bankAccount->bank_mfo, 'bank_edrpou' => $bankAccount->bank_edrpou, 'payment_purpose_template_uk' => $bankAccount->payment_purpose_template_uk] : null,
            'client' => ['display_name' => $order->client?->display_name, 'phone' => $order->client?->phone, 'email' => $order->client?->email],
            'service_order' => ['order_number' => $order->order_number, 'received_at' => optional($order->received_at)->format('d.m.Y H:i'), 'ready_at' => optional($order->ready_at)->format('d.m.Y H:i'), 'item_name' => $order->item_name, 'brand' => $order->brand, 'model' => $order->model, 'serial_number' => $order->serial_number, 'reported_problem' => $order->reported_problem, 'intake_condition' => $order->intake_condition, 'accessories' => $order->accessories, 'work_result' => $order->work_result],
            'items' => $order->items->map(fn ($item) => ['type' => $item->type?->value ?? $item->type, 'name' => $item->name, 'description' => $item->description, 'quantity' => (float) $item->quantity, 'unit_price' => (float) $item->unit_price, 'total_price' => (float) $item->total_price])->values()->all(),
            'payments' => $order->payments->map(fn ($payment) => ['type' => $payment->type?->value ?? $payment->type, 'method' => $payment->method?->value ?? $payment->method, 'amount' => (float) $payment->amount, 'paid_at' => optional($payment->paid_at)->format('d.m.Y H:i')])->values()->all(),
            'totals' => ['estimated_price' => (float) $order->estimated_price, 'agreed_price' => (float) $order->agreed_price, 'final_price' => (float) $order->final_price, 'paid_amount' => (float) $order->paid_amount, 'balance_amount' => (float) $order->balance_amount],
            'terms' => ['repair_terms_uk' => $preferences->repair_terms_uk, 'storage_terms_uk' => $preferences->storage_terms_uk, 'diagnostic_terms_uk' => $preferences->diagnostic_terms_uk, 'warranty_terms_uk' => $preferences->warranty_terms_uk, 'invoice_footer_uk' => $preferences->invoice_footer_uk, 'completion_act_footer_uk' => $preferences->completion_act_footer_uk],
        ];
    }
}
