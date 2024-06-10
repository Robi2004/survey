<?php
use Database\Seeders\PermissionRolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('shows the stats for admin', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();

    $this->get('/homepage')
    ->assertStatus(200)
    ->assertInertia(fn (Assert $page) => $page
    ->component('Admin/HomePage')
    );
});

test('shows the chart of surveys created by authenticated user', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsUser();

    // Effectue la requête GET pour la page d'accueil
    $this->get('/homepage')
    ->assertStatus(200)
    ->assertInertia(fn (Assert $page) => $page
    ->component('HomePage'));

});
