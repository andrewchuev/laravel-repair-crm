<?php

use App\Models\User;

it('logs in an active user through fortify', function (): void {
    $user = createActiveUser([
        'email' => 'admin@example.com',
        'password' => 'password',
    ]);

    $response = $this->postJson('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response
        ->assertOk()
        ->assertJsonPath('two_factor', false);

    $this->assertAuthenticatedAs($user);
});

it('rejects login for an inactive user', function (): void {
    $user = createInactiveUser([
        'email' => 'inactive@example.com',
        'password' => 'password',
    ]);

    $response = $this->postJson('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email']);

    expect(auth()->check())->toBeFalse();
});
