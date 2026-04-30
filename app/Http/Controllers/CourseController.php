<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['lessons', 'level'])->orderBy('order')->get();
        $user = Auth::user();

        foreach ($courses as $course) {
            $course->progress_percent = $course->getProgressForUser($user);
        }

        return view('courses.index', compact('courses'));
    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug)->with(['lessons.exercises'])->firstOrFail();
        $completedLessons = UserProgress::where('user_id', Auth::id())->pluck('lesson_id');

        return view('courses.show', compact('course', 'completedLessons'));
    }
}
