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

    $survey = Survey::factory()->create();
    $question = Question::factory()->create(['id_survey' => $survey->id, 'type' => "Text"]);
    $question = Question::factory()->create(['id_survey' => $survey->id, 'type' => "Select"]);
    $answer = Answer::factory()->create(['id_question' => $question->id]);
    $answer = Answer::factory()->create(['id_question' => $question->id]);
    $question = Question::factory()->create(['id_survey' => $survey->id, 'type' => "Multiple Select"]);
    
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
    $survey = Survey::factory()->create();

    $response = get("/answers/{$survey->id}/thanks");

    $response->assertStatus(200)
             ->assertInertia('Survey/ThanksSurvey', ['survey' => $survey->toArray()]);
});

test('shows the form for editing the specified answer', function () {
    $answer = Answer::factory()->create();

    $response = get("/answers/{$answer->id}/edit");

    $response->assertStatus(200)
             ->assertInertia('Admin/EditAnswer', ['answer' => $answer->toArray()]);
});

test('updates the specified answer', function () {
    $answer = Answer::factory()->create();
    $updatedContent = 'Updated answer content';

    $this->patch("/answers/{$answer->id}", ['content' => $updatedContent])
         ->assertRedirect("/surveys/{$answer->question->survey->id}/answer");

    $updatedAnswer = Answer::find($answer->id);
    expect($updatedAnswer->content)->toBe($updatedContent);
});

test('removes the specified answer from storage', function () {
    $answer = Answer::factory()->create();

    $this->delete("/answers/{$answer->id}")
         ->assertStatus(200);

    $this->assertDatabaseMissing('answers', ['id' => $answer->id]);
});

test('displays survey for getting answers', function () {
    $survey = Survey::factory()->create();
    $question = Question::factory()->create(['id_survey' => $survey->id]);

    get("/surveys/{$survey->id}/getAnswer")
        ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Survey/GetAnswerSurvey')
            ->has('survey.questions', 1)
        );
});