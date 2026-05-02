<?php
namespace App\Http\Controllers;

use App\Models\UserProgress;
use App\Models\UserExerciseAttempt;
use App\Models\Course;
use App\Models\Lesson;
use Carbon\Carbon;

class StatsController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('level');
        $userId = $user->id;

        // === XP POR DÍA (últimos 14 días) ===
        $xpByDay = [];
        for ($i = 13; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $label = Carbon::now()->subDays($i)->format('d/m');
            
            $xp = UserProgress::where('user_id', $userId)
                ->whereDate('completed_at', $date)
                ->join('lessons', 'user_progress.lesson_id', '=', 'lessons.id')
                ->sum('lessons.xp_reward');

            $xpByDay[] = [
                'date'  => $date,
                'label' => $label,
                'xp'    => (int) $xp,
            ];
        }

        // === LECCIONES POR DÍA (últimos 14 días) ===
        $lessonsByDay = [];
        for ($i = 13; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $label = Carbon::now()->subDays($i)->format('d/m');
            
            $count = UserProgress::where('user_id', $userId)
                ->whereDate('completed_at', $date)
                ->count();

            $lessonsByDay[] = [
                'date'  => $date,
                'label' => $label,
                'count' => $count,
            ];
        }

        // === ESTADÍSTICAS GENERALES ===
        $totalLessonsCompleted = UserProgress::where('user_id', $userId)->count();
        
        $totalExercisesAttempted = UserExerciseAttempt::where('user_id', $userId)->count();
        
        $totalExercisesCorrect = UserExerciseAttempt::where('user_id', $userId)
            ->where('is_correct', true)->count();
        
        $accuracy = $totalExercisesAttempted > 0
            ? round(($totalExercisesCorrect / $totalExercisesAttempted) * 100)
            : 0;

        $firstActivity = UserProgress::where('user_id', $userId)
            ->orderBy('completed_at', 'asc')
            ->first();
        
        $daysLearning = $firstActivity
            ? (int) Carbon::parse($firstActivity->completed_at)->diffInDays(Carbon::now()) + 1
            : 0;

        // === PROGRESO POR CURSO ===
        $coursesProgress = Course::with('lessons')->get()->map(function($course) use ($userId) {
            $total = $course->lessons->count();
            $completed = UserProgress::where('user_id', $userId)
                ->whereIn('lesson_id', $course->lessons->pluck('id'))
                ->count();
            $completed = min($completed, $total);
            $percent = $total > 0 ? (int) round(($completed / $total) * 100) : 0;
            return [
                'course'    => $course,
                'total'     => $total,
                'completed' => $completed,
                'percent'   => min(100, $percent),
            ];
        })->filter(fn($c) => $c['total'] > 0)
          ->sortByDesc('percent')
          ->values();

        // === DÍAS ACTIVOS ESTE MES ===
        $daysInMonth = Carbon::now()->daysInMonth;

        $activeDaysThisMonth = \DB::table('user_progress')
            ->where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->whereRaw('MONTH(completed_at) = ?', [Carbon::now()->month])
            ->whereRaw('YEAR(completed_at) = ?', [Carbon::now()->year])
            ->selectRaw('DATE(completed_at) as activity_day')
            ->distinct()
            ->get()
            ->count();

        // Hard cap — never exceed current day of month
        // (can't have been active on future days)
        $activeDaysThisMonth = min($activeDaysThisMonth, Carbon::now()->day);
        $activeDaysThisMonth = min($activeDaysThisMonth, $daysInMonth);

        // === MEJOR RACHA ===
        $allDates = \App\Models\UserProgress::where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->selectRaw('DATE(completed_at) as day')
            ->distinct()
            ->orderBy('day')
            ->pluck('day')
            ->toArray();

        $bestStreak = 0;
        $currentStreak = 1;

        if (count($allDates) === 0) {
            $bestStreak = 0;
        } elseif (count($allDates) === 1) {
            $bestStreak = 1;
        } else {
            for ($i = 1; $i < count($allDates); $i++) {
                $prev = \Carbon\Carbon::parse($allDates[$i - 1]);
                $curr = \Carbon\Carbon::parse($allDates[$i]);
                $diff = $prev->diffInDays($curr);

                if ($diff === 1) {
                    $currentStreak++;
                } else {
                    if ($currentStreak > $bestStreak) {
                        $bestStreak = $currentStreak;
                    }
                    $currentStreak = 1;
                }
            }
            // Check last streak
            if ($currentStreak > $bestStreak) {
                $bestStreak = $currentStreak;
            }
        }

        // Also compare with the stored streak in users table
        // in case the calculated one is lower
        $bestStreak = max($bestStreak, $user->streak_days ?? 0);

        // === ACTIVIDAD POR HORA DEL DÍA ===
        $activityByHour = [];
        for ($h = 0; $h < 24; $h++) {
            $count = UserProgress::where('user_id', $userId)
                ->whereNotNull('completed_at')
                ->whereRaw('HOUR(completed_at) = ?', [$h])
                ->count();
            $activityByHour[$h] = $count;
        }
        $peakHour = array_search(max($activityByHour), $activityByHour);

        // === XP TOTAL Y NIVEL SIGUIENTE ===
        $nextLevel = \App\Models\Level::where('min_xp', '>', $user->xp)
            ->orderBy('min_xp')
            ->first();
        
        $xpToNextLevel = $nextLevel 
            ? $nextLevel->min_xp - $user->xp 
            : 0;
        
        $xpProgress = 0;
        if ($user->level && $nextLevel) {
            $range = $nextLevel->min_xp - $user->level->min_xp;
            $earned = $user->xp - $user->level->min_xp;
            $xpProgress = $range > 0 ? (int) round(($earned / $range) * 100) : 100;
        }

        return view('stats.index', compact(
            'user', 'xpByDay', 'lessonsByDay',
            'totalLessonsCompleted', 'totalExercisesAttempted',
            'totalExercisesCorrect', 'accuracy', 'daysLearning',
            'coursesProgress', 'activeDaysThisMonth', 'daysInMonth',
            'bestStreak', 'activityByHour', 'peakHour',
            'nextLevel', 'xpToNextLevel', 'xpProgress'
        ));
    }
}
