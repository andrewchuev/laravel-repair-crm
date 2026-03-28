<?php

it('adds an internal comment to a service order', function (): void {
    $user = createActiveUser([
        'name' => 'Admin User',
    ]);
    $order = createServiceOrder(actor: $user);

    $response = $this
        ->actingAs($user)
        ->postJson("/service-orders/{$order->id}/comments", [
            'visibility' => 'internal',
            'body' => 'Corrosion found near charging circuit.',
        ]);

    $response
        ->assertCreated()
        ->assertJsonPath('data.visibility', 'internal')
        ->assertJsonPath('data.body', 'Corrosion found near charging circuit.')
        ->assertJsonPath('data.user.id', $user->id)
        ->assertJsonPath('data.user.name', 'Admin User');

    $this->assertDatabaseHas('service_order_comments', [
        'service_order_id' => $order->id,
        'user_id' => $user->id,
        'visibility' => 'internal',
        'body' => 'Corrosion found near charging circuit.',
    ]);
});
