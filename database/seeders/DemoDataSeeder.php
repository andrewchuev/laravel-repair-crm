<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Clients\Infrastructure\Persistence\Models\Client;
use App\Modules\ServiceOrders\Application\Actions\CreateServiceOrderAction;
use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderCategory;
use App\Modules\ServiceOrders\Domain\Enums\ServiceOrderPriority;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->where('email', 'admin@example.com')->first();

        if (! $admin) {
            return;
        }

        $client = Client::query()->firstOrCreate(
            ['phone' => '+380501112233'],
            [
                'type' => 'person',
                'full_name' => 'John Doe',
                'email' => 'john@example.com',
                'created_by_user_id' => $admin->id,
            ]
        );

        if ($client->serviceOrders()->exists()) {
            return;
        }

        app(CreateServiceOrderAction::class)->execute([
            'client_id' => $client->id,
            'priority' => ServiceOrderPriority::NORMAL->value,
            'category' => ServiceOrderCategory::LAPTOP->value,
            'item_name' => 'Lenovo ThinkPad T480',
            'brand' => 'Lenovo',
            'model' => 'ThinkPad T480',
            'serial_number' => 'SN-T480-001',
            'reported_problem' => 'Laptop does not power on.',
            'intake_condition' => 'Visible wear on top cover.',
            'accessories' => 'Charger included.',
        ], $admin);
    }
}
