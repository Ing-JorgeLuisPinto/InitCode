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
use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/select-level', [AuthController::class, 'selectLevel'])->name('select-level')->middleware('auth');
Route::post('/select-level', [AuthController::class, 'saveLevel'])->name('select-level.save')->middleware('auth');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])
        ->name('index');

    // Courses
    Route::get('/courses', [AdminController::class, 'courses'])
        ->name('courses');
    Route::get('/courses/create', 
        [AdminController::class, 'createCourse'])
        ->name('courses.create');
    Route::post('/courses', 
        [AdminController::class, 'storeCourse'])
        ->name('courses.store');
    Route::get('/courses/{course}/edit', 
        [AdminController::class, 'editCourse'])
        ->name('courses.edit');
    Route::put('/courses/{course}', 
        [AdminController::class, 'updateCourse'])
        ->name('courses.update');
    Route::delete('/courses/{course}', 
        [AdminController::class, 'destroyCourse'])
        ->name('courses.destroy');

    // Lessons
    Route::get('/courses/{course}/lessons', 
        [AdminController::class, 'lessons'])
        ->name('lessons');
    Route::get('/courses/{course}/lessons/create', 
        [AdminController::class, 'createLesson'])
        ->name('lessons.create');
    Route::post('/courses/{course}/lessons', 
        [AdminController::class, 'storeLesson'])
        ->name('lessons.store');
    Route::get('/lessons/{lesson}', 
        [AdminController::class, 'showLesson'])
        ->name('lesson.show');
    Route::get('/lessons/{lesson}/edit', 
        [AdminController::class, 'editLesson'])
        ->name('lessons.edit');
    Route::put('/lessons/{lesson}', 
        [AdminController::class, 'updateLesson'])
        ->name('lessons.update');
    Route::delete('/lessons/{lesson}', 
        [AdminController::class, 'destroyLesson'])
        ->name('lessons.destroy');

    // Exercises
    Route::get('/lessons/{lesson}/exercise', 
        [AdminController::class, 'editExercise'])
        ->name('exercise.edit');
    Route::post('/lessons/{lesson}/exercise', 
        [AdminController::class, 'storeExercise'])
        ->name('exercise.store');
    Route::put('/exercises/{exercise}', 
        [AdminController::class, 'updateExercise'])
        ->name('exercise.update');
    Route::delete('/exercises/{exercise}', 
        [AdminController::class, 'destroyExercise'])
        ->name('exercise.destroy');

    // Users
    Route::get('/users', [AdminController::class, 'users'])
        ->name('users');
    Route::get('/users/{user}', 
        [AdminController::class, 'showUser'])
        ->name('users.show');
    Route::put('/users/{user}/toggle-premium', 
        [AdminController::class, 'togglePremium'])
        ->name('users.toggle-premium');
    Route::put('/users/{user}/toggle-admin', 
        [AdminController::class, 'toggleAdmin'])
        ->name('users.toggle-admin');
    Route::post('/users/{user}/reset-progress', 
        [AdminController::class, 'resetUserProgress'])
        ->name('users.reset-progress');
    Route::delete('/users/{user}', 
        [AdminController::class, 'destroyUser'])
        ->name('users.destroy');

    // Achievements
    Route::get('/achievements', 
        [AdminController::class, 'achievements'])
        ->name('achievements');
    Route::get('/achievements/create', 
        [AdminController::class, 'createAchievement'])
        ->name('achievements.create');
    Route::post('/achievements', 
        [AdminController::class, 'storeAchievement'])
        ->name('achievements.store');
    Route::get('/achievements/{achievement}/edit', 
        [AdminController::class, 'editAchievement'])
        ->name('achievements.edit');
    Route::put('/achievements/{achievement}', 
        [AdminController::class, 'updateAchievement'])
        ->name('achievements.update');
    Route::delete('/achievements/{achievement}', 
        [AdminController::class, 'destroyAchievement'])
        ->name('achievements.destroy');
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
    Route::get('/stats', [StatsController::class, 'index'])
        ->name('stats.index');

    
    // Default profile routes from Breeze (modified to show)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');
    
    Route::get('/courses/{course}/certificate', 
        [CertificateController::class, 'generate'])
        ->name('certificate.generate');
});

require __DIR__.'/auth.php';
