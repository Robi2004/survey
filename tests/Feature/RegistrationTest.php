<?php

use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Database\Seeders\PermissionRolesSeeder;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
})->skip(function () {
    return ! Features::enabled(Features::registration());
}, 'Registration support is not enabled.');

test('registration screen cannot be rendered if support is disabled', function () {
    $response = $this->get('/register');

    $response->assertStatus(404);
})->skip(function () {
    return Features::enabled(Features::registration());
}, 'Registration support is enabled.');

test('new users can register', function () {
    $this->seed(PermissionRolesSeeder::class);
    $response = $this->post('/register', [
        'firstName' => 'Test User',
        'lastName' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        'role' => 'user'
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('home', absolute: false));
})->skip(function () {
    return ! Features::enabled(Features::registration());
}, 'Registration support is not enabled.');

test('admin can register', function () {
    $this->seed(PermissionRolesSeeder::class);
    $response = $this->post('/register', [
        'firstName' => 'admim',
        'lastName' => 'admim',
        'email' => 'admin@admim.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        'role' => 'admin'
    ]);
    $this->assertAuthenticated();
    $response->assertRedirect(route('home', absolute: false));
})->skip(function () {
    return ! Features::enabled(Features::registration());
}, 'Registration support is not enabled.');

