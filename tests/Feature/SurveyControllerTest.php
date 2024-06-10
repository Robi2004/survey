<?php

use App\Models\Survey;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use Database\Seeders\PermissionRolesSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    // Reset the storage fake for each test
    Storage::fake('public');
});

test('displays the admin survey dashboard for admins', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();
    Survey::factory()->count(15)->create();

    $this->get('/surveys')
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Admin/SurveyDashboard')
            ->has('surveys.data', 12) // Assuming pagination with 12 per page
        );
});

test('displays the user survey dashboard for regular users', function () {
    $this->seed(PermissionRolesSeeder::class);
    $user = loginAsUser();
    Survey::factory()->count(5)->create(['id_user' => $user->id]);

    $this->get('/surveys')
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Survey/SurveyDashboard')
            ->has('surveys.data', 5)
        );
});

test('shows the form for creating a new survey for users', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsUser();
    $this->get('/surveys/create')
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Survey/CreateSurvey')
        );
});

test('stores a newly created survey', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsUser();

    $this->post('/surveys', [
            'title' => 'New Survey',
            'image' => UploadedFile::fake()->image('survey.jpg'),
        ])
        ->assertSessionHasNoErrors();

    $survey = Survey::first();

    expect($survey)->not->toBeNull();

    $expectedPath = 'image/' . basename($survey->image);
    Storage::disk('public')->assertExists($expectedPath);

    $this->get(route('surveys.show', ['id' => $survey->id]))
        ->assertStatus(200);
});

test('displays a specific survey', function () {

    $this->seed(PermissionRolesSeeder::class);
    $user = loginAsUser();
    $survey = Survey::factory()->create(['id_user' => $user->id]);

    $this        ->get(route('surveys.show', ['id' => $survey->id]))
    ->assertStatus(200)
    ->assertInertia(fn (Assert $page) => $page
        ->component('Survey/Survey')
        ->where('survey.0.id', $survey->id)
    );
});

test('shows the form for editing a survey', function () {
    $this->seed(PermissionRolesSeeder::class);
    $user = loginAsUser();
    $survey = Survey::factory()->create(['id_user' => $user->id]);

    $this->get("/surveys/{$survey->id}/edit")
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Survey/EditSurvey')
        );
});

test('updates the specified survey', function () {
    $this->seed(PermissionRolesSeeder::class);
    $user = loginAsUser();
    $survey = Survey::factory()->create(['id_user' => $user->id]);

    $this->post("/surveys/{$survey->id}", [
            'title' => 'Updated Survey',
            'image' => UploadedFile::fake()->image('new_survey.jpg'),
        ])
        ->assertStatus(200);

    Storage::disk('public')->assertMissing($survey->image);
});

test('deletes the specified survey', function () {
    $this->seed(PermissionRolesSeeder::class);
    $user = loginAsUser();
    $survey = Survey::factory()->create(['id_user' => $user->id]);

    $this->delete("/surveys/{$survey->id}")
    ->assertStatus(200)
    ->assertJson(['message' => 'Le sondage a été supprimé']);

    Storage::disk('public')->assertMissing($survey->image);
});

test('displays answers for a survey', function () {
    $this->seed(PermissionRolesSeeder::class);
    $user = loginAsUser();
    $survey = Survey::factory()->create(['id_user' => $user->id]);
    $question = Question::factory()->create(['id_survey' => $survey->id]);
    Answer::factory()->create(['id_question' => $question->id]);

    $this->get("/surveys/{$survey->id}/answer")
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Survey/AnswerSurvey')
            ->has('survey.questions', 1)
        );
});

test('displays survey for getting answers', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsUser();

    $user = User::factory()->create();
    $survey = Survey::factory()->create(['id_user' => $user->id]);
    $question = Question::factory()->create(['id_survey' => $survey->id]);
    Answer::factory()->create(['id_question' => $question->id]);

    $this->get("/surveys/{$survey->id}/getAnswer")
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Survey/GetAnswerSurvey')
            ->has('survey.questions', 1)
        );
});