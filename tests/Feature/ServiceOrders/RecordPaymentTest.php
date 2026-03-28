<?php

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrderItem;

it('records a payment and updates paid and balance amounts', function (): void {
    $user = createActiveUser();
    $order = createServiceOrder(actor: $user, overrides: [
        'final_price' => 1500.00,
        'balance_amount' => 1500.00,
    ]);

    ServiceOrderItem::query()->create([
        'service_order_id' => $order->id,
        'type' => 'work',
        'name' => 'Motherboard repair',
        'description' => null,
        'quantity' => 1,
        'unit_price' => 1500.00,
        'cost_price' => 0,
        'total_price' => 1500.00,
        'position' => 1,
        'created_by_user_id' => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->postJson("/service-orders/{$order->id}/payments", [
            'type' => 'payment',
            'method' => 'cash',
            'amount' => 500.00,
            'comment' => 'Advance payment',
        ]);

    $response
        ->assertCreated()
        ->assertJsonPath('data.type', 'payment')
        ->assertJsonPath('data.method', 'cash');

    $this->assertDatabaseHas('payments', [
        'service_order_id' => $order->id,
        'type' => 'payment',
        'method' => 'cash',
        'amount' => 500.00,
        'created_by_user_id' => $user->id,
    ]);

    $order->refresh();

    expect($order->final_price)->toBe('1500.00')
        ->and($order->paid_amount)->toBe('500.00')
        ->and($order->balance_amount)->toBe('1000.00');
});
