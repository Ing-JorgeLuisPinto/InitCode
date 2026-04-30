<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function show($courseSlug, $lessonSlug)
    {
        $lesson = Lesson::where('slug', $lessonSlug)
            ->whereHas('course', function ($query) use ($courseSlug) {
                $query->where('slug', $courseSlug);
            })
            ->with(['course', 'exercises'])
            ->firstOrFail();

        $user = Auth::user();
        $alreadyCompleted = UserProgress::where(['user_id' => $user->id, 'lesson_id' => $lesson->id])->exists();
        $newAchievements = [];

        if (!$alreadyCompleted && $lesson->type === 'reading') {
            UserProgress::create([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
                'xp_earned' => $lesson->xp_reward,
                'completed_at' => now()
            ]);
            $user->addXP($lesson->xp_reward);
            $user->updateStreak();
            $newAchievements = $user->checkAchievements();
            $alreadyCompleted = true;
        }

        $exercise = $lesson->exercises->first();

        // Find next lesson
        $nextLesson = Lesson::where('course_id', $lesson->course_id)
            ->where('order', '>', $lesson->order)
            ->orderBy('order', 'asc')
            ->first();

        if (!$nextLesson) {
            $nextCourse = Course::where('order', '>', $lesson->course->order)
                ->orderBy('order', 'asc')
                ->first();
            if ($nextCourse) {
                $nextLesson = Lesson::where('course_id', $nextCourse->id)
                    ->orderBy('order', 'asc')
                    ->first();
            }
        }

        return view('lessons.show', compact('lesson', 'exercise', 'alreadyCompleted', 'nextLesson', 'newAchievements'));
    }
}
