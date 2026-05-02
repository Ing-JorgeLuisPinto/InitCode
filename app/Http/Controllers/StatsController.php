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
            ? Carbon::parse($firstActivity->completed_at)->diffInDays(Carbon::now()) + 1
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
        $activeDaysThisMonth = UserProgress::where('user_id', $userId)
            ->whereMonth('completed_at', Carbon::now()->month)
            ->whereYear('completed_at', Carbon::now()->year)
            ->selectRaw('DATE(completed_at) as day')
            ->distinct()
            ->count();

        $daysInMonth = Carbon::now()->daysInMonth;

        // === MEJOR RACHA ===
        $allDates = UserProgress::where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->selectRaw('DATE(completed_at) as day')
            ->distinct()
            ->orderBy('day')
            ->pluck('day')
            ->map(fn($d) => Carbon::parse($d))
            ->toArray();

        $bestStreak = 0;
        $currentStreak = 0;
        for ($i = 0; $i < count($allDates); $i++) {
            if ($i === 0) {
                $currentStreak = 1;
            } else {
                $diff = $allDates[$i-1]->diffInDays($allDates[$i]);
                if ($diff === 1) {
                    $currentStreak++;
                } else {
                    $bestStreak = max($bestStreak, $currentStreak);
                    $currentStreak = 1;
                }
            }
        }
        $bestStreak = max($bestStreak, $currentStreak);

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
