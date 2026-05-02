<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Achievement;
use App\Models\Course;
use App\Models\UserProgress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $user = Auth::user()->load(['level', 'userAchievements.achievement']);
        $allAchievements = Achievement::all();
        $earnedIds = $user->userAchievements->pluck('achievement_id');
        $completedLessons = UserProgress::where('user_id', $user->id)->count();
        
        $coursesProgress = Course::with('lessons')->get()
            ->map(function($course) use ($user) {
                $total = $course->lessons->count();
                $completed = \App\Models\UserProgress::where('user_id', $user->id)
                    ->whereIn('lesson_id', $course->lessons->pluck('id'))
                    ->count();
                // Cap completed at total to never exceed 100%
                $completed = min($completed, $total);
                $percent = $total > 0 
                    ? (int) round(($completed / $total) * 100) 
                    : 0;
                $percent = min(100, $percent);
                return [
                    'course'  => $course,
                    'percent' => $percent,
                ];
            });

        return view('profile.show', compact('user', 'allAchievements', 'earnedIds', 'completedLessons', 'coursesProgress'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
