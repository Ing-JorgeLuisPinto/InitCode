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
        $user = auth()->user()->fresh()->load('level');
        
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
            ->latest('completed_at')
            ->take(5)
            ->get()
            ->map(function($progress) {
                $progress->completed_at = $progress->completed_at 
                    ? \Carbon\Carbon::parse($progress->completed_at) 
                    : null;
                return $progress;
            });

        $lastActivity = $user->last_activity_date 
            ? \Carbon\Carbon::parse($user->last_activity_date)
            : null;
        $practicedToday = $lastActivity && $lastActivity->isToday();
        $practicedYesterday = $lastActivity && $lastActivity->isYesterday();

        return view('dashboard', compact(
            'user', 'nextLesson', 'completedCount', 
            'recentProgress', 'practicedToday', 'practicedYesterday'
        ));
    }
}
