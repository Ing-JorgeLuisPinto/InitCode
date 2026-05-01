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
        // Get code safely - never null
        $raw = $request->input('code') 
            ?? $request->input('submitted_code') 
            ?? '';
        $raw = is_string($raw) ? $raw : '';
        
        // If empty, return friendly error without saving to DB
        if (trim($raw) === '') {
            return response()->json([
                'correct' => false,
                'message' => '¡Escribe tu respuesta primero! Mira la estructura de referencia 👆',
                'xp_earned' => 0,
                'new_total_xp' => auth()->user()->xp
            ]);
        }

        $revealed = $request->boolean('revealed');
        
        // Normalize submitted code
        $submitted = $this->normalizeCode($raw);
        
        // Normalize expected output  
        $expected = $this->normalizeCode($exercise->expected_output);
        
        // Also normalize solution for comparison
        $solution = $this->normalizeCode($exercise->solution_code);
        
        // Check correctness multiple ways
        $isCorrect = (
            $submitted === $expected ||
            $submitted === $solution ||
            str_contains($submitted, $expected) ||
            str_contains($solution, $submitted) ||
            // Check if running the code would produce expected output
            $this->extractOutput($submitted) === $this->normalizeCode($exercise->expected_output)
        );
        
        $user = Auth::user();

        // Save attempt
        UserExerciseAttempt::create([
            'user_id' => $user->id,
            'exercise_id' => $exercise->id,
            'submitted_code' => $raw ?: '(vacío)',
            'is_correct' => $isCorrect,
            'attempted_at' => now()
        ]);
        
        $xpEarned = 0;
        if ($isCorrect) {
            $alreadySolved = UserExerciseAttempt::where([
                'user_id' => auth()->id(),
                'exercise_id' => $exercise->id,
                'is_correct' => true
            ])->count() === 1; // count is 1 because we just inserted it above

            if ($alreadySolved) {
                $lesson = $exercise->lesson()->with('course')->first();
                $exerciseXp = $revealed ? 5 : $exercise->xp_reward;
                $lessonXp = $lesson->xp_reward;
                $xpEarned = $exerciseXp + $lessonXp;

                auth()->user()->addXP($xpEarned);
                auth()->user()->updateStreak();
                
                $newAchievements = auth()->user()->checkAchievements();

                UserProgress::firstOrCreate(
                    ['user_id' => auth()->id(), 'lesson_id' => $lesson->id],
                    ['xp_earned' => $xpEarned, 'completed_at' => now()]
                );
            }
        }
        
        return response()->json([
            'correct' => $isCorrect,
            'message' => $isCorrect 
                ? '¡Correcto! Muy bien hecho 🎉' 
                : '¡Casi! Recuerda: ' . $exercise->expected_output . ' 💪',
            'xp_earned' => $xpEarned,  // This is the REAL amount earned
            'new_total_xp' => auth()->user()->fresh()->xp,
            'new_achievements' => isset($newAchievements) 
                ? collect($newAchievements)->map(fn($a) => [
                    'name' => $a->name,
                    'icon' => $a->icon,
                    'description' => $a->description,
                ])->values()->toArray()
                : []
        ]);
    }

    private function normalizeCode(?string $code): string
    {
        if ($code === null) return '';
        
        // Remove placeholder comments
        $code = str_replace(
            ['// ESCRIBE TU CODIGO AQUI', '// Escribe tu código aquí...', '// Tu código aquí'],
            '',
            $code
        );
        // Normalize whitespace and case
        $code = strtolower(trim($code));
        $code = preg_replace('/\s+/', ' ', $code);
        $code = str_replace(["\r\n", "\r"], "\n", $code);
        // Remove spaces around operators and punctuation for looser matching
        $code = preg_replace('/\s*([=;{}()[\],])\s*/', '$1', $code);
        return $code;
    }

    private function extractOutput(string $code): string
    {
        // For simple echo statements, extract what would be printed
        // e.g. echo 'Ana'; -> ana
        if (preg_match("/echo\s+['\"](.+?)['\"]/i", $code, $matches)) {
            return strtolower(trim($matches[1]));
        }
        return $code;
    }
}
