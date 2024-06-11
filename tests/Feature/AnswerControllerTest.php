<?php

use App\Models\User;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Answer;
use Database\Seeders\PermissionRolesSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\{actingAs, get, post, delete};


beforeEach(function () {
    // Reset the storage fake for each test
    Storage::fake('public');
});

test('stores newly created answers', function () {
    $user = User::factory()->create();
    $survey = Survey::factory()->create(['id_user' => $user->id]);
    $question = Question::factory()->create(['id_survey' => $survey->id, 'type' => "Text"]);
    $question = Question::factory()->create(['id_survey' => $survey->id, 'type' => "Select"]);
    Answer::factory()->count(3)->create(['id_question' => $question->id]);
    $question = Question::factory()->create(['id_survey' => $survey->id, 'type' => "CheckBox"]);
    Answer::factory()->count(3)->create(['id_question' => $question->id]);
    
    $userRequestData = [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'city' => 'New York',
        'questions' => [
            [
                'id' => 1,
                'type' => 'Text',
                'userAnswers' => 'Answer for question 1'
            ],
            [
                'id' => 2,
                'type' => 'Select',
                'userAnswers' => 1 
            ],
            [
                'id' => 3,
                'type' => 'CheckBox',
                'userAnswers' => [2, 3]
            ]
        ]
    ];

    $this->post("/answers/{$survey->id}", $userRequestData)
        ->assertRedirect("/answers/{$survey->id}/thanks");

    // Assertions for data creation can be added if needed
});

test('shows the thanks page after submitting answers', function () {
    $user = User::factory()->create();
    $survey = Survey::factory()->create(['id_user' => $user->id]);

    $this->get("/answers/{$survey->id}/thanks")
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
        ->component('Survey/ThanksSurvey')
    );
});

test('shows the form for editing the specified answer', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();

    $user = User::factory()->create();
    $survey = Survey::factory()->create(['id_user' => $user->id]);
    $question = Question::factory()->create(['id_survey' => $survey->id, 'type' => "Text"]);
    $answer = Answer::factory()->create(['id_question' => $question->id]);

    $this->get("/answers/{$answer->id}/edit")
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
        ->component('Admin/EditAnswer'));
});

test('updates the specified answer', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();

    $user = User::factory()->create();
    $survey = Survey::factory()->create(['id_user' => $user->id]);
    $question = Question::factory()->create(['id_survey' => $survey->id]);
    $answer = Answer::factory()->create(['id_question' => $question->id]);

    $updatedContent = 'Updated answer content';

    $this->patch("/answers/{$answer->id}", ['content' => $updatedContent])
         ->assertRedirect("/surveys/{$survey->id}/answer");

    $updatedAnswer = Answer::find($answer->id);
    expect($updatedAnswer->content)->toBe($updatedContent);
});

test('removes the specified answer from storage', function () {
    $this->seed(PermissionRolesSeeder::class);
    loginAsAdmin();

    $user = User::factory()->create();
    $survey = Survey::factory()->create(['id_user' => $user->id]);
    $question = Question::factory()->create(['id_survey' => $survey->id]);
    $answer = Answer::factory()->create(['id_question' => $question->id]);
    $answer = Answer::factory()->create();

    $this->delete("/answers/{$answer->id}")
         ->assertStatus(200);

    $this->assertDatabaseMissing('answers', ['id' => $answer->id]);
});
