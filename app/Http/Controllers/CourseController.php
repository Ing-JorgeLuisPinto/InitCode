<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $levelFilter = $request->input('level', '');
        $statusFilter = $request->input('status', '');

        $query = Course::with(['lessons', 'level'])->orderBy('order');

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if (!empty($levelFilter)) {
            $query->where('level_id', $levelFilter);
        }

        $courses = $query->get();

        $coursesWithProgress = $courses->map(function($course) {
            $total     = $course->lessons->count();
            $completed = \App\Models\UserProgress::where('user_id', auth()->id())
                ->whereIn('lesson_id', $course->lessons->pluck('id'))
                ->count();
            $completed = min($completed, $total);
            $percent   = $total > 0 ? (int) round(($completed / $total) * 100) : 0;
            $course->progress_percent  = min(100, $percent);
            $course->completed_lessons = $completed;
            return $course;
        });

        if ($statusFilter === 'en-progreso') {
            $coursesWithProgress = $coursesWithProgress->filter(
                fn($c) => $c->progress_percent > 0 && $c->progress_percent < 100
            );
        } elseif ($statusFilter === 'completados') {
            $coursesWithProgress = $coursesWithProgress->filter(
                fn($c) => $c->progress_percent === 100
            );
        } elseif ($statusFilter === 'no-iniciados') {
            $coursesWithProgress = $coursesWithProgress->filter(
                fn($c) => $c->progress_percent === 0
            );
        }

        $levels = \App\Models\Level::all();

        return view('courses.index', [
            'courses'      => $coursesWithProgress,
            'levels'       => $levels,
            'search'       => $search,
            'levelFilter'  => $levelFilter,
            'statusFilter' => $statusFilter,
            'totalResults' => $coursesWithProgress->count(),
        ]);
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
