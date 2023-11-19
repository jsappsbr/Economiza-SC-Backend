<?php

use function Pest\Laravel\{postJson, assertDatabaseHas};

it('creates a new user', function () {
    $response = postJson('/api/signup', [
        'name' => 'Test',
        'email' => 'test@email.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(201);

    assertDatabaseHas('users', ['name' => 'Test', 'email' => 'test@email.com']);
});
