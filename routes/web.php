<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/select-level', [AuthController::class, 'selectLevel'])->name('select-level')->middleware('auth');
Route::post('/select-level', [AuthController::class, 'saveLevel'])->name('select-level.save')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
    Route::get('/exercises/{exercise}', [ExerciseController::class, 'show'])->name('exercises.show');
    Route::post('/exercises/{exercise}/submit', [ExerciseController::class, 'submit'])->name('exercises.submit');
    Route::get('/tutor', [TutorController::class, 'index'])->name('tutor.index');
    Route::post('/tutor/message', [TutorController::class, 'sendMessage'])->name('tutor.message');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
    Route::post('/lesson-chat', [TutorController::class, 'lessonChat'])
        ->name('lesson.chat');
    
    // Default profile routes from Breeze (modified to show)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
