<?php

it('creates a service order and writes initial status history', function (): void {
    $user = createActiveUser();
    $client = createClient($user, [
        'full_name' => 'Order Customer',
        'phone' => '+380501000001',
    ]);

    $response = $this
        ->actingAs($user)
        ->postJson('/service-orders', [
            'client_id' => $client->id,
            'priority' => 'normal',
            'category' => 'laptop',
            'item_name' => 'Lenovo ThinkPad T14',
            'brand' => 'Lenovo',
            'model' => 'ThinkPad T14',
            'serial_number' => 'LNV-T14-001',
            'reported_problem' => 'Does not power on',
            'intake_condition' => 'Used condition, minor scratches',
            'accessories' => 'Charger included',
            'estimated_price' => 1200.00,
            'agreed_price' => 0,
            'internal_notes' => 'Created by Pest test',
        ]);

    $response
        ->assertCreated()
        ->assertJsonPath('data.client.id', $client->id)
        ->assertJsonPath('data.status', 'new')
        ->assertJsonPath('data.category', 'laptop')
        ->assertJsonPath('data.item_name', 'Lenovo ThinkPad T14');

    $orderId = $response->json('data.id');

    $this->assertDatabaseHas('service_orders', [
        'id' => $orderId,
        'client_id' => $client->id,
        'accepted_by_user_id' => $user->id,
        'status' => 'new',
        'category' => 'laptop',
        'item_name' => 'Lenovo ThinkPad T14',
    ]);

    $this->assertDatabaseHas('service_order_status_history', [
        'service_order_id' => $orderId,
        'new_status' => 'new',
        'changed_by_user_id' => $user->id,
    ]);
});
