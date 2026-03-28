<?php

use App\Models\User;
use App\Modules\Clients\Domain\Enums\ClientType;
use App\Modules\Clients\Infrastructure\Persistence\Models\Client;
use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderCategory;
use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderPriority;
use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderStatus;
use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;
use App\Modules\Users\Domain\Enums\UserRole;
use App\Shared\Domain\Enums\SupportedLocale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(Tests\TestCase::class, RefreshDatabase::class)->in('Feature');

function createActiveUser(array $overrides = []): User
{
    return User::factory()->create(array_merge([
        'name' => 'Test Admin',
        'email' => 'tester+'.Str::uuid().'@example.com',
        'password' => 'password',
        'role' => UserRole::ADMIN->value,
        'is_active' => true,
        'preferred_locale' => SupportedLocale::EN->value,
    ], $overrides));
}

function createInactiveUser(array $overrides = []): User
{
    return createActiveUser(array_merge([
        'is_active' => false,
    ], $overrides));
}

function createClient(?User $actor = null, array $overrides = []): Client
{
    $actor ??= createActiveUser();
    $type = $overrides['type'] ?? ClientType::PERSON->value;

    $defaults = [
        'type' => $type,
        'full_name' => $type === ClientType::PERSON->value ? 'John Tester' : null,
        'company_name' => $type === ClientType::COMPANY->value ? 'Acme Test LLC' : null,
        'phone' => '+38067'.fake()->unique()->numerify('#######'),
        'phone_secondary' => null,
        'email' => fake()->unique()->safeEmail(),
        'notes' => null,
        'source' => null,
        'created_by_user_id' => $actor->id,
    ];

    return Client::query()->create(array_merge($defaults, $overrides));
}

function createServiceOrder(?Client $client = null, ?User $actor = null, array $overrides = []): ServiceOrder
{
    $actor ??= createActiveUser();
    $client ??= createClient($actor);

    return ServiceOrder::query()->create(array_merge([
        'order_number' => 'TEST-'.strtoupper(Str::random(10)),
        'client_id' => $client->id,
        'accepted_by_user_id' => $actor->id,
        'assigned_master_id' => null,
        'status' => ServiceOrderStatus::NEW->value,
        'priority' => ServiceOrderPriority::NORMAL->value,
        'category' => ServiceOrderCategory::LAPTOP->value,
        'item_name' => 'Dell Latitude 5420',
        'brand' => 'Dell',
        'model' => 'Latitude 5420',
        'serial_number' => 'SN-'.Str::upper(Str::random(8)),
        'reported_problem' => 'Does not power on',
        'intake_condition' => 'Used condition',
        'accessories' => 'Charger',
        'intake_checklist' => [],
        'device_snapshot' => [],
        'diagnostic_summary' => null,
        'work_result' => null,
        'internal_notes' => null,
        'customer_notes' => null,
        'estimated_price' => 0,
        'agreed_price' => 0,
        'final_price' => 0,
        'paid_amount' => 0,
        'balance_amount' => 0,
        'received_at' => now(),
        'promised_at' => null,
        'approved_at' => null,
        'ready_at' => null,
        'delivered_at' => null,
        'warranty_until' => null,
        'cancelled_at' => null,
        'cancellation_reason' => null,
    ], $overrides));
}
