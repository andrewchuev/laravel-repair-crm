<?php

it('adds an item to a service order and recalculates totals', function (): void {
    $user = createActiveUser();
    $order = createServiceOrder(actor: $user);

    $response = $this
        ->actingAs($user)
        ->postJson("/service-orders/{$order->id}/items", [
            'type' => 'work',
            'name' => 'Diagnostics and motherboard repair',
            'description' => 'Power rail diagnostics and solder work',
            'quantity' => 1,
            'unit_price' => 1500.00,
            'cost_price' => 0,
            'position' => 1,
        ]);

    $response
        ->assertCreated()
        ->assertJsonPath('data.type', 'work')
        ->assertJsonPath('data.name', 'Diagnostics and motherboard repair');

    $this->assertDatabaseHas('service_order_items', [
        'service_order_id' => $order->id,
        'type' => 'work',
        'name' => 'Diagnostics and motherboard repair',
        'total_price' => 1500.00,
        'created_by_user_id' => $user->id,
    ]);

    $order->refresh();

    expect($order->final_price)->toBe('1500.00')
        ->and($order->paid_amount)->toBe('0.00')
        ->and($order->balance_amount)->toBe('1500.00');
});
