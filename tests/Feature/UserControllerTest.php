<?php
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\patch;
use Database\Seeders\PermissionRolesSeeder;
use Inertia\Testing\AssertableInertia as Assert;

test('displays a listing of users', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();

    User::factory()->count(15)->create()->each(function ($user) {
        $user->assignRole('user');
    });
 
    $this->get('/users')
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Admin/User/UserDashboard')
            ->has('users.data', 12)
        );
});

test('displays a listing of users pending inscription', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();
    $users = User::factory()->count(15)->create(['password' => Hash::make('password')]);

    $this->get('/users/inscription')
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
        ->component('Admin/User/InscriptionDashboard'));
});

test('validates a user', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();
    $user = User::factory()->create(['password' => Hash::make('password')]);

    $this->assertCount(0, $user->roles);

    $this->put("/users/inscription/{$user->id}")
        ->assertRedirect('/users/inscription');

    $user->refresh();
    $this->assertCount(1, $user->roles);
});

test('shows the form for creating a new user', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();
    get('/users/create')
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
        ->component('Admin/User/CreateUser'));
});

test('stores a newly created user', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();
    $userData = User::factory()->raw();

    post('/users', $userData)
        ->assertRedirect('/users');

    $this->assertDatabaseHas('users', [
        'email' => $userData['email']
    ]);
});

test('shows the specified user', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();
    $user = User::factory()->create();
    $user->assignRole('user');

    get("/users/{$user->id}")
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
        ->component('Admin/User/User'));
});

test('shows the specified inscription', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();
    $user = User::factory()->create();

    get("/users/{$user->id}")
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
        ->component('Admin/User/Inscription'));
});

test('shows the form for editing the specified user', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();
    $user = User::factory()->create();

    $this->get("/users/{$user->id}/edit")
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
        ->component('Admin/User/EditUser')
        ->where('user.0.id', $user->id));
});

test('updates the specified user', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();
    $user = User::factory()->create();
    $newUserData = User::factory()->raw();

    patch("/users/{$user->id}", $newUserData)
        ->assertRedirect('/users');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'email' => $newUserData['email']
    ]);
});

test('removes the specified user from storage', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();
    
    $user = User::factory()->create();

    $this->delete("/users/{$user->id}")
        ->assertStatus(200);

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});
