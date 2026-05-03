<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\UserExerciseAttempt;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    public function show(Exercise $exercise)
    {
        $lesson = $exercise->lesson()->with('course')->first();
        $nextLesson = \App\Models\Lesson::where('course_id', $lesson->course_id)
            ->where('order', '>', $lesson->order)
            ->orderBy('order', 'asc')
            ->first();
        return view('exercises.show', compact('exercise', 'lesson', 'nextLesson'));
    }

    public function submit(Request $request, Exercise $exercise)
    {
        // Get code safely
        $raw = $request->input('code')
            ?? $request->input('submitted_code')
            ?? '';
        $raw = is_string($raw) ? $raw : '';

        // Return friendly error if empty
        if (trim($raw) === '') {
            return response()->json([
                'correct' => false,
                'message' => '¡Escribe tu respuesta primero! 💡',
                'xp_earned' => 0,
                'new_total_xp' => auth()->user()->xp,
                'new_achievements' => []
            ]);
        }

        $revealed = $request->boolean('revealed', false);

        $isCorrect = $this->isAnswerCorrect($raw, $exercise);

        // Check BEFORE saving if this is the first correct attempt
        $alreadySolvedCorrectly = UserExerciseAttempt::where('user_id', auth()->id())
            ->where('exercise_id', $exercise->id)
            ->where('is_correct', true)
            ->exists();

        // Save attempt
        UserExerciseAttempt::create([
            'user_id'        => auth()->id(),
            'exercise_id'    => $exercise->id,
            'submitted_code' => $raw ?: '(vacío)',
            'is_correct'     => $isCorrect,
            'attempted_at'   => now()
        ]);

        $xpEarned = 0;
        $newAchievements = [];

        if ($isCorrect && !$alreadySolvedCorrectly) {
            // First time solving correctly — award XP
            $xpEarned = $revealed ? 5 : $exercise->xp_reward;

            \Log::info('XP awarded: ' . $xpEarned .
                ' | exercise_id: ' . $exercise->id .
                ' | xp_reward: ' . $exercise->xp_reward .
                ' | revealed: ' . ($revealed ? 'yes' : 'no'));

            auth()->user()->addXP($xpEarned);
            auth()->user()->updateStreak();

            // Mark lesson as completed
            $lesson = $exercise->lesson()->with('course')->first();
            UserProgress::firstOrCreate(
                ['user_id' => auth()->id(), 'lesson_id' => $lesson->id],
                ['xp_earned' => $xpEarned, 'completed_at' => now()]
            );

            $newAchievements = auth()->user()->checkAchievements();
        } elseif ($isCorrect && $alreadySolvedCorrectly) {
            // Already solved before — no XP but still correct
            \Log::info('Exercise already solved — no XP awarded. exercise_id: ' . $exercise->id);
        }

        return response()->json([
            'correct'          => $isCorrect,
            'message'          => $isCorrect
                ? ($alreadySolvedCorrectly
                    ? '✅ ¡Correcto! Ya habías completado este ejercicio antes.'
                    : '¡Correcto! Muy bien hecho 🎉')
                : '¡Casi! Inténtalo de nuevo 💪',
            'xp_earned'        => $xpEarned,
            'new_total_xp'     => auth()->user()->fresh()->xp,
            'new_achievements' => collect($newAchievements)
                ->map(fn($a) => [
                    'name'        => $a->name,
                    'icon'        => $a->icon,
                    'description' => $a->description,
                ])->values()->toArray()
        ]);
    }

    private function normalizeCode(?string $code): string
    {
        if ($code === null) return '';
        $code = str_replace(
            ['// ESCRIBE TU CODIGO AQUI', '// Escribe tu código aquí...', '// Tu código aquí'],
            '', $code
        );
        $code = trim($code);
        $code = preg_replace('/\r\n|\r/', "\n", $code);
        $code = preg_replace('/[ \t]+/', ' ', $code);
        $code = strtolower($code);
        return $code;
    }

    private function isAnswerCorrect(string $submitted, Exercise $exercise): bool
    {
        $normalizedSubmitted = $this->normalizeCode($submitted);
        $normalizedExpected  = $this->normalizeCode($exercise->expected_output);
        $normalizedSolution  = $this->normalizeCode($exercise->solution_code);

        // Minimum length check — prevents single character bypass
        if (strlen($normalizedSubmitted) < 2 && strlen($normalizedExpected) > 2) {
            return false;
        }

        return (
            $normalizedSubmitted === $normalizedExpected ||
            $normalizedSubmitted === $normalizedSolution ||
            str_contains($normalizedSubmitted, $normalizedExpected) ||
            str_contains($normalizedSolution, $normalizedSubmitted) ||
            $this->extractOutput($normalizedSubmitted) === $normalizedExpected
        );
    }

    private function extractOutput(?string $code): string
    {
        if (!$code) return '';
        if (preg_match("/echo\s+['\"](.+?)['\"]/i", $code, $m)) {
            return strtolower(trim($m[1]));
        }
        return $code;
    }
}
