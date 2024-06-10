<?php

use App\Models\User;
use Database\Seeders\PermissionRolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('show the export page', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();

    $this->get('/excel')
        ->assertStatus(200)        
        ->assertInertia(fn (Assert $page) => $page
        ->component('Admin/ExportExcel')
    );
});

test('export users', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();

    User::factory()->count(5)->create();

    $this->get('/excel/export?firstName=First%20Name&lastName=Last%20Name&email=Email')
        ->assertStatus(200)
        ->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
});

