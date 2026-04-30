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
        return view('exercises.show', compact('exercise'));
    }

    public function submit(Request $request, Exercise $exercise)
    {
        $submittedRaw = $request->input('code');
        
        // Normalize strings: trim, lower, remove extra spaces, normalize line breaks
        $normalize = function($str) {
            $str = str_replace(["\r\n", "\r"], "\n", $str); // Normalize line breaks
            $str = preg_replace('/\s+/', ' ', $str);        // Remove extra spaces/tabs/newlines
            return strtolower(trim($str));
        };

        $submitted = $normalize($submittedRaw);
        $expected = $normalize($exercise->expected_output);

        $isCorrect = ($submitted === $expected) || 
                     str_contains($submitted, $expected) || 
                     ($expected !== '' && str_contains($expected, $submitted));

        $user = Auth::user();

        UserExerciseAttempt::create([
            'user_id' => $user->id,
            'exercise_id' => $exercise->id,
            'submitted_code' => $submittedRaw,
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
                $xpEarned = $exercise->xp_reward;
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
                : '¡Casi! Recuerda que la respuesta esperada es: ' . $exercise->expected_output . ' 💪 Cópiala exactamente si no encuentras el error.',
            'xp_earned' => $xpEarned,
            'new_total_xp' => $user->fresh()->xp
        ]);
    }
}
