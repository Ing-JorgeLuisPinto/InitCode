<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/select-level', [AuthController::class, 'selectLevel'])->name('select-level')->middleware('auth');
Route::post('/select-level', [AuthController::class, 'saveLevel'])->name('select-level.save')->middleware('auth');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    
    // Courses
    Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
    Route::get('/courses/create', [AdminController::class, 'createCourse'])->name('courses.create');
    Route::post('/courses', [AdminController::class, 'storeCourse'])->name('courses.store');
    Route::get('/courses/{course}/edit', [AdminController::class, 'editCourse'])->name('courses.edit');
    Route::put('/courses/{course}', [AdminController::class, 'updateCourse'])->name('courses.update');
    
    // Lessons
    Route::get('/courses/{course}/lessons', [AdminController::class, 'lessons'])->name('lessons');
    Route::get('/courses/{course}/lessons/create', [AdminController::class, 'createLesson'])->name('lessons.create');
    Route::post('/courses/{course}/lessons', [AdminController::class, 'storeLesson'])->name('lessons.store');
    Route::get('/courses/{course}/lessons/{lesson}/edit', [AdminController::class, 'editLesson'])->name('lessons.edit');
    Route::put('/courses/{course}/lessons/{lesson}', [AdminController::class, 'updateLesson'])->name('lessons.update');
    
    // Exercises
    Route::get('/lessons/{lesson}/exercise/edit', [AdminController::class, 'editExercise'])->name('exercises.edit');
    Route::put('/lessons/{lesson}/exercise', [AdminController::class, 'updateExercise'])->name('exercises.update');
    
    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/toggle-premium', [AdminController::class, 'togglePremium'])->name('users.premium');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
});

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
    
    Route::get('/courses/{course}/certificate', 
        [CertificateController::class, 'generate'])
        ->name('certificate.generate');
});

require __DIR__.'/auth.php';
