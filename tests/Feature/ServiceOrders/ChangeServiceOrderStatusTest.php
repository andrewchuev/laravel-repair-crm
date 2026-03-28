<?php

use App\Modules\ServiceOrders\Infrastructure\Persistence\Models\ServiceOrder;

it('changes service order status using an allowed transition', function (): void {
    $user = createActiveUser();
    $order = createServiceOrder(actor: $user, overrides: [
        'status' => 'new',
    ]);

    $response = $this
        ->actingAs($user)
        ->postJson("/service-orders/{$order->id}/status", [
            'status' => 'diagnostics',
            'comment' => 'Moved to diagnostics',
        ]);

    $response
        ->assertOk()
        ->assertJsonPath('data.id', $order->id)
        ->assertJsonPath('data.status', 'diagnostics');

    $this->assertDatabaseHas('service_orders', [
        'id' => $order->id,
        'status' => 'diagnostics',
    ]);

    $this->assertDatabaseHas('service_order_status_history', [
        'service_order_id' => $order->id,
        'old_status' => 'new',
        'new_status' => 'diagnostics',
        'changed_by_user_id' => $user->id,
    ]);
});
