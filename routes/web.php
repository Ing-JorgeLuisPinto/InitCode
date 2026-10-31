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

Route::middleware('auth')->group(function () {
    Route::get('/email/verify-otp',  [App\Http\Controllers\Auth\EmailOtpController::class, 'show'])
        ->name('verification.otp.show');
    Route::post('/email/send-otp',   [App\Http\Controllers\Auth\EmailOtpController::class, 'send'])
        ->name('verification.otp.send');
    Route::post('/email/verify-otp', [App\Http\Controllers\Auth\EmailOtpController::class, 'verify'])
        ->name('verification.otp.verify');
});

Route::middleware('auth')->group(function () {
    Route::get('/select-level', [AuthController::class, 'selectLevel'])
        ->name('select-level');
    Route::post('/select-level', [AuthController::class, 'saveLevel'])
        ->name('select-level.save');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/',  [AdminController::class, 'index'])->name('index');

    // Courses
    Route::get('/courses/create',        [AdminController::class, 'createCourse'])->name('courses.create');
    Route::post('/courses',              [AdminController::class, 'storeCourse'])->name('courses.store');
    Route::get('/courses/{course}/edit', [AdminController::class, 'editCourse'])->name('courses.edit');
    Route::put('/courses/{course}',      [AdminController::class, 'updateCourse'])->name('courses.update');
    Route::delete('/courses/{course}',   [AdminController::class, 'destroyCourse'])->name('courses.destroy');

    // Lessons
    Route::get('/courses/{course}/lessons/create', [AdminController::class, 'createLesson'])->name('lessons.create');
    Route::post('/courses/{course}/lessons',       [AdminController::class, 'storeLesson'])->name('lessons.store');
    Route::get('/lessons/{lesson}/edit',           [AdminController::class, 'editLesson'])->name('lessons.edit');
    Route::put('/lessons/{lesson}',                [AdminController::class, 'updateLesson'])->name('lessons.update');
    Route::delete('/lessons/{lesson}',             [AdminController::class, 'destroyLesson'])->name('lessons.destroy');

    // Achievements
    Route::get('/achievements/create',             [AdminController::class, 'createAchievement'])->name('achievements.create');
    Route::post('/achievements',                   [AdminController::class, 'storeAchievement'])->name('achievements.store');
    Route::get('/achievements/{achievement}/edit', [AdminController::class, 'editAchievement'])->name('achievements.edit');
    Route::put('/achievements/{achievement}',      [AdminController::class, 'updateAchievement'])->name('achievements.update');
    Route::delete('/achievements/{achievement}',   [AdminController::class, 'destroyAchievement'])->name('achievements.destroy');

    // Users
    Route::get('/users',                    [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/make-admin', [AdminController::class, 'makeAdmin'])->name('users.makeAdmin');
    Route::post('/users/{user}/remove-admin',[AdminController::class,'removeAdmin'])->name('users.removeAdmin');
});

Route::middleware('auth')->group(function () {
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
