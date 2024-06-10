<?php

use App\Models\Survey;
use App\Models\User;
use Database\Seeders\PermissionRolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('show the export page', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();

    $this->get('/pdf')
        ->assertStatus(200)        
        ->assertInertia(fn (Assert $page) => $page
        ->component('Admin/ExportPDF')
    );
});

test('export surveys to PDF', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();

    Survey::factory()->count(5)->create();

    $this->get('/pdf/export?title=Survey%20Title&image=SampleImageURL')
        ->assertStatus(200)
        ->assertHeader('Content-Type', 'application/pdf');
});

