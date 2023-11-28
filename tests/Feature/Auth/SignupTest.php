<?php

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\{postJson, assertDatabaseHas};

describe('validations', function () {
    it('returns the required validation when the values are not provided', function () {
        $response = postJson('/api/signup', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
        $response->assertJsonFragment([
            "errors" => [
                "name" => [trans('validation.required', ['attribute' => 'name'])],
                "email" => [trans('validation.required', ['attribute' => 'email'])],
                "password" => [trans('validation.required', ['attribute' => 'password'])],
            ]
        ]);
    });

    it('validates the email field', function () {
        $response = postJson('/api/signup', [
            'name' => 'Test',
            'email' => 'invalid-email',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
        $response->assertJsonFragment([
            "errors" => [
                "email" => [trans('validation.email', ['attribute' => 'email'])]
            ]
        ]);
    });

    it('does not allow users with the same email', function () {
        $user = User::factory()->create();

        $response = postJson('/api/signup', [
            'name' => 'Test',
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    });
});


it('creates a new user', function () {
    $response = postJson('/api/signup', [
        'name' => 'Test',
        'email' => 'test@email.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(Response::HTTP_CREATED);

    assertDatabaseHas('users', ['name' => 'Test', 'email' => 'test@email.com']);
});
