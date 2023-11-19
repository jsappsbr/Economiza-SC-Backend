<?php

use App\Models\User;
use function Pest\Laravel\{postJson, assertDatabaseHas};

it('creates auth token', function () {
   $user = User::factory()->create();

    $response = postJson('/api/sanctum/token', [
         'email' => $user->email,
         'password' => 'password',
         'device_name' => 'test',
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure(['token']);
    $this->assertNotNull($user->tokens()->first());
});
