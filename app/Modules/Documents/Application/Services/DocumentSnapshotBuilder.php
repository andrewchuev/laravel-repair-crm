<?php

namespace App\Modules\Documents\Application\Services;

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\Settings\Infrastructure\Persistence\Models\BankAccount;
use App\Modules\Settings\Infrastructure\Persistence\Models\BusinessProfile;

class DocumentSnapshotBuilder
{
    public function build(ServiceOrder $order, BusinessProfile $profile, ?BankAccount $bankAccount): array
    {
        $order->loadMissing(['client', 'items', 'payments']);

        $items = $order->items->map(function ($item) {
            return [
                'type' => $item->type->value ?? $item->type,
                'name' => $item->name,
                'description' => $item->description,
                'quantity' => (float) $item->quantity,
                'unit_price' => (float) $item->unit_price,
                'total_price' => (float) $item->total_price,
            ];
        })->values()->all();

        if (empty($items)) {
            $price = (float) ($order->agreed_price > 0 ? $order->agreed_price : $order->estimated_price);
            $items[] = [
                'type' => 'service',
                'name' => $order->item_name,
                'description' => $order->reported_problem,
                'quantity' => 1,
                'unit_price' => $price,
                'total_price' => $price,
            ];
        }

        return [
            'business_profile' => [
                'legal_name' => $profile->legal_name,
                'short_name' => $profile->short_name,
                'tax_id' => $profile->tax_id,
                'registration_number' => $profile->registration_number,
                'phone' => $profile->phone,
                'email' => $profile->email,
                'website' => $profile->website,
                'registration_address' => $profile->registration_address,
                'actual_address' => $profile->actual_address,
                'city' => $profile->city,
                'postal_code' => $profile->postal_code,
                'signer_name' => $profile->signer_name,
                'signer_title' => $profile->signer_title,
            ],
            'bank_account' => $bankAccount ? [
                'recipient' => $bankAccount->recipient,
                'iban' => $bankAccount->iban,
                'bank_name' => $bankAccount->bank_name,
                'bank_mfo' => $bankAccount->bank_mfo,
                'bank_edrpou' => $bankAccount->bank_edrpou,
                'currency' => $bankAccount->currency,
                'payment_purpose_template' => $bankAccount->payment_purpose_template,
            ] : null,
            'client' => [
                'id' => $order->client?->id,
                'name' => $order->client?->display_name,
                'phone' => $order->client?->phone,
                'email' => $order->client?->email,
            ],
            'service_order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'received_at' => optional($order->received_at)?->format('d.m.Y H:i'),
                'item_name' => $order->item_name,
                'brand' => $order->brand,
                'model' => $order->model,
                'serial_number' => $order->serial_number,
                'reported_problem' => $order->reported_problem,
                'intake_condition' => $order->intake_condition,
                'accessories' => $order->accessories,
            ],
            'items' => $items,
            'totals' => [
                'estimated_price' => (float) $order->estimated_price,
                'agreed_price' => (float) $order->agreed_price,
                'final_price' => (float) $order->final_price,
                'paid_amount' => (float) $order->paid_amount,
                'balance_amount' => (float) $order->balance_amount,
            ],
        ];
    }
}
