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
        $raw = $request->input('code', '');
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
            'submitted_code' => $raw,
            'is_correct' => $isCorrect,
            'attempted_at' => now()
        ]);
        
        $xpEarned = 0;
        if ($isCorrect) {
            $alreadySolved = UserExerciseAttempt::where([
                'user_id' => $user->id,
                'exercise_id' => $exercise->id,
                'is_correct' => true
            ])->count() === 1;
            
            if ($alreadySolved) {
                $xpEarned = $revealed ? 5 : $exercise->xp_reward;
                $user->addXP($xpEarned);
                $user->updateStreak();
                $user->checkAchievements();
                
                $lesson = $exercise->lesson;
                UserProgress::firstOrCreate(
                    ['user_id' => $user->id, 'lesson_id' => $lesson->id],
                    ['xp_earned' => $lesson->xp_reward, 'completed_at' => now()]
                );
            }
        }
        
        return response()->json([
            'correct' => $isCorrect,
            'message' => $isCorrect 
                ? '¡Correcto! Muy bien hecho 🎉' 
                : '¡Casi! Recuerda que la respuesta esperada es: ' . $exercise->expected_output . ' 💪',
            'xp_earned' => $xpEarned,
            'new_total_xp' => $user->fresh()->xp
        ]);
    }

    private function normalizeCode(string $code): string
    {
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
