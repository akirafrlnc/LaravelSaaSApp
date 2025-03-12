<?php

use App\Models\User;
use Illuminate\Support\Facades\Session;
test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    // Start session for CSRF token
    Session::start();

    $response = $this->post('/login', [
        '_token' => csrf_token(), // ✅ Add CSRF token
        'email' => $user->email,
        'password' => 'password',
    ]);

    // Ensure the user is authenticated
    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('dashboard'));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
