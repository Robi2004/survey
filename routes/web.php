<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ChartController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/homepage', [ChartController::class, 'index'])->name('homepage');

    Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
    Route::get('/surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
    Route::get('/surveys/{id}/edit', [SurveyController::class, 'edit'])->name('surveys.edit');

    Route::get('/surveys/{id}', [SurveyController::class, 'show'])->name('surveys.show');

    Route::post('/surveys/{id}', [SurveyController::class, 'update'])->name('surveys.update');
    Route::post('/surveys', [SurveyController::class, 'store'])->name('surveys.store');
    
    Route::delete('/surveys/{id}', [SurveyController::class, 'destroy'])->name('surveys.destroy');

    Route::get('/questions/{id}', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/create/{id}', [QuestionController::class, 'create'])->name('questions.create');
    Route::get('/questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit');

    Route::post('/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');
});
