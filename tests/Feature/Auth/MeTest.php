<?php

it('returns the authenticated user from me endpoint', function (): void {
    $user = createActiveUser([
        'name' => 'Admin',
        'email' => 'admin@example.com',
    ]);

    $response = $this
        ->actingAs($user)
        ->getJson('/me');

    $response
        ->assertOk()
        ->assertJsonPath('data.id', $user->id)
        ->assertJsonPath('data.email', 'admin@example.com')
        ->assertJsonPath('data.role', 'admin')
        ->assertJsonPath('data.preferred_locale', 'en')
        ->assertJsonPath('data.is_active', true);
});

it('rejects unauthenticated access to me endpoint', function (): void {
    $this->getJson('/me')->assertUnauthorized();
});
