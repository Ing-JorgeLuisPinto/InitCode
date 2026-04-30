<?php

namespace App\Http\Controllers;

use App\Models\UserProgress;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('level');
        
        // Find first lesson not in user_progress for user, ordered by course order then lesson order
        $nextLesson = Lesson::whereNotExists(function ($query) use ($user) {
                $query->select('*')
                    ->from('user_progress')
                    ->whereColumn('user_progress.lesson_id', 'lessons.id')
                    ->where('user_progress.user_id', $user->id);
            })
            ->join('courses', 'lessons.course_id', '=', 'courses.id')
            ->orderBy('courses.order')
            ->orderBy('lessons.order')
            ->select('lessons.*')
            ->first();

        $completedCount = UserProgress::where('user_id', $user->id)->count();
        $recentProgress = UserProgress::where('user_id', $user->id)
            ->with('lesson.course')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('user', 'nextLesson', 'completedCount', 'recentProgress'));
    }
}
