<?php

declare(strict_types=1);

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
// Register Test //
it('register User Token', function (): void {
    $user = UserFactory::new()->make();

    $response = $this->postJson('/api/user', [
        'name' => $user->name,
        'email' => $user->email,
        'password' => $user->password,
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'user' => ['id', 'name', 'email'],
            'token'
        ]);

    $this->assertDatabaseHas('users', [
        'email' => $user->email,
    ]);
});

it('data validation', function (): void {
    $response = $this->postJson('/api/user', [
        'email' => "unvalide_data",
    ]);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'errors'
        ]);
});

// Loggin Test

it('incorrect password', function (): void {
    $user = UserFactory::new()->create();

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => "wrongPass",
    ]);

    $response->assertStatus(401)
        ->assertJsonStructure([
            "message"
        ]);
});

it('login data validation', function (): void {

    $response = $this->postJson('/api/login', [
        'email' => "unvalide_data",
    ]);

    $response->assertStatus(422)
        ->assertJsonStructure([
            "errors"
        ]);
});

it('login User Token', function (): void {
    $user = UserFactory::new()->create();

    $request = [
        "email" => $user->email,
        "password" => "password",
    ];

    $response = $this->postJson('/api/login', $request);

    $response->assertStatus(201)
    ->assertJsonStructure([
        'user',
        'token'
    ]);
});


