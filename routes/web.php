<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\AnswerController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('home');

Route::get('/surveys/{id}/getAnswer', [SurveyController::class, 'getAnswer'])->name('surveys.getAnswer');
Route::post('/answers/{id}', [AnswerController::class, 'store'])->name('answers.store');
Route::get('/answers/{id}/thanks', [AnswerController::class, 'thanksShow'])->name('answers.thanks');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:user',
])->group(function () {
    Route::get('/surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
    Route::post('/surveys', [SurveyController::class, 'store'])->name('surveys.store');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:user|admin',
])->group(function () {
    Route::get('/homepage', [ChartController::class, 'homepage'])->name('homepage');
    Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
    Route::get('/surveys/{id}/answer', [SurveyController::class, 'answer'])->name('surveys.answer');
    Route::get('/surveys/{id}/edit', [SurveyController::class, 'edit'])->name('surveys.edit');
    Route::get('/surveys/{id}', [SurveyController::class, 'show'])->name('surveys.show');
    Route::post('/surveys/{id}', [SurveyController::class, 'update'])->name('surveys.update');
    Route::delete('/surveys/{id}', [SurveyController::class, 'destroy'])->name('surveys.destroy');
    Route::get('/questions/{id}', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/create/{id}', [QuestionController::class, 'create'])->name('questions.create');
    Route::get('/questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::patch('/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin',
])->group(function () {
    Route::get('/pdf', [PDFController::class, 'index'])->name('pdf.index');
    Route::get('/pdf/export', [PDFController::class, 'export'])->name('pdf.export');
    Route::get('/excel', [ExcelController::class, 'index'])->name('excel.index');
    Route::get('/excel/export', [ExcelController::class, 'export'])->name('excel.export');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/inscription', [UserController::class, 'inscription'])->name('users.inscription');
    Route::patch('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::put('/users/inscription/{id}', [UserController::class, 'validate'])->name('users.validate');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/answers/{id}/edit', [AnswerController::class, 'edit'])->name('answers.edit');
    Route::patch('/answers/{id}', [AnswerController::class, 'update'])->name('answers.update');
    Route::delete('/answers/{id}', [AnswerController::class, 'destroy'])->name('answers.destroy');
});
