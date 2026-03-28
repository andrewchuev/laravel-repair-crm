<?php

use App\Modules\Clients\Infrastructure\Persistence\Models\Client;

it('lists clients for an authenticated user', function (): void {
    $user = createActiveUser();

    $first = createClient($user, [
        'full_name' => 'John Doe',
        'phone' => '+380501112233',
    ]);

    $second = createClient($user, [
        'type' => 'company',
        'full_name' => null,
        'company_name' => 'PrintLab LLC',
        'phone' => '+380442223344',
    ]);

    $response = $this
        ->actingAs($user)
        ->getJson('/clients');

    $response
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonFragment(['id' => $first->id, 'display_name' => 'John Doe'])
        ->assertJsonFragment(['id' => $second->id, 'display_name' => 'PrintLab LLC']);
});

it('creates a person client', function (): void {
    $user = createActiveUser();

    $response = $this
        ->actingAs($user)
        ->postJson('/clients', [
            'type' => 'person',
            'full_name' => 'Alice Cooper',
            'phone' => '+380671234567',
            'email' => 'alice@example.com',
            'notes' => 'Walk-in customer',
        ]);

    $response
        ->assertCreated()
        ->assertJsonPath('data.type', 'person')
        ->assertJsonPath('data.display_name', 'Alice Cooper')
        ->assertJsonPath('data.phone', '+380671234567');

    $clientId = $response->json('data.id');

    $this->assertDatabaseHas('clients', [
        'id' => $clientId,
        'type' => 'person',
        'full_name' => 'Alice Cooper',
        'phone' => '+380671234567',
        'created_by_user_id' => $user->id,
    ]);
});

it('validates that a company client requires company_name', function (): void {
    $user = createActiveUser();

    $response = $this
        ->actingAs($user)
        ->postJson('/clients', [
            'type' => 'company',
            'phone' => '+380441234567',
        ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['company_name']);

    expect(Client::query()->count())->toBe(0);
});
