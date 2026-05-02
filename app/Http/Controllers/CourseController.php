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
        $course = Course::where('slug', $slug)
            ->with(['lessons' => function($q) {
                $q->orderBy('order');
            }, 'lessons.exercises'])
            ->firstOrFail();

        // Get ONLY the lesson IDs that belong to this course
        $courseLessonIds = $course->lessons->pluck('id');

        // Get completed lessons for this user that belong to this course
        $completedLessons = \App\Models\UserProgress::where('user_id', auth()->id())
            ->whereIn('lesson_id', $courseLessonIds)
            ->pluck('lesson_id');

        return view('courses.show', compact('course', 'completedLessons'));
    }
}
