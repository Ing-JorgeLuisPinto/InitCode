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
        $submitted = trim($request->input('code'));
        $expected = trim($exercise->expected_output);
        $isCorrect = ($submitted === $expected);
        $user = Auth::user();

        UserExerciseAttempt::create([
            'user_id' => $user->id,
            'exercise_id' => $exercise->id,
            'submitted_code' => $submitted,
            'is_correct' => $isCorrect,
            'attempted_at' => now()
        ]);

        $xpEarned = 0;
        if ($isCorrect) {
            $alreadySolved = UserExerciseAttempt::where([
                'user_id' => $user->id,
                'exercise_id' => $exercise->id,
                'is_correct' => true
            ])->count() === 1; // It was just created, so if count is 1, it's the first time

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
            'message' => $isCorrect ? '¡Correcto! Muy bien hecho 🎉' : 'Casi, inténtalo de nuevo. Revisa la sintaxis 💪',
            'xp_earned' => $xpEarned,
            'new_total_xp' => $user->fresh()->xp
        ]);
    }
}
