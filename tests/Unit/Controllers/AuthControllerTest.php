<?php

declare(strict_types=1);

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
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
