<?php

use App\Models\Survey;
use App\Models\Question;
use Database\Seeders\PermissionRolesSeeder;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    // Reset the storage fake for each test
    Storage::fake('public');
});

test('displays a listing of questions', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsUser();
    $survey = Survey::factory()->create();
    Question::factory()->count(15)->create(['id_survey' => $survey->id]);

    $this->get('/questions/'.$survey->id)
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Question/QuestionDashboard')
            ->has('questions.data', 12) // Assuming pagination with 12 per page
        );
});

test('shows the form for creating a new question', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsUser();
    $survey = Survey::factory()->create();

    $this->get('/questions/create/'.$survey->id)
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Question/CreateQuestion')
        );
});

test('stores a newly created question', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsUser();
    $survey = Survey::factory()->create();

    $this->post('/questions', [
            'content' => 'New Question',
            'type' => 'Text',
            'id_survey' => $survey->id,
        ])
        ->assertSessionHasNoErrors();

    $question = Question::first();
    expect($question)->not->toBeNull();
});

test('shows the form for editing the specified question', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsUser();
    $survey = Survey::factory()->create();
    $question = Question::factory()->create(['id_survey' => $survey->id]);

    $this->get("/questions/{$question->id}/edit")
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Question/EditQuestion')
        );
});

test('updates the specified question', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsUser();
    $survey = Survey::factory()->create();
    $question = Question::factory()->create(['id_survey' => $survey->id]);

    $this->patch("/questions/{$question->id}", [
            'content' => 'Updated Question',
            'type' => 'Text',
            'id_survey' => $survey->id,
        ])
        ->assertStatus(302);

    $updatedQuestion = Question::find($question->id);
    expect($updatedQuestion->content)->toBe('Updated Question');
});

test('removes the specified question from storage', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsUser();
    $survey = Survey::factory()->create();
    $question = Question::factory()->create(['id_survey' => $survey->id]);

    $this->delete("/questions/{$question->id}")
        ->assertStatus(200)
        ->assertJson(['message' => 'La question à été supprimé']);
});