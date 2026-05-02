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

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'   => 'required|string|max:255',
            'bio'    => 'nullable|string|max:300',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required'  => 'El nombre es obligatorio.',
            'avatar.image'   => 'El archivo debe ser una imagen.',
            'avatar.max'     => 'La imagen no puede superar 2MB.',
        ]);

        $data = [
            'name' => $request->name,
            'bio'  => $request->bio,
        ];

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
                \Storage::disk('public')->delete($user->avatar);
            }

            $file = $request->file('avatar');
            $filename = 'avatar_' . auth()->id() . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Store with intervention or direct copy to preserve quality
            $file->storeAs('avatars', $filename, 'public');
            $data['avatar'] = 'avatars/' . $filename;
        }

        $user->update($data);

        return redirect()->route('profile.show')
            ->with('success', '✅ Perfil actualizado correctamente');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Ingresa tu contraseña actual.',
            'password.required'         => 'La nueva contraseña es obligatoria.',
            'password.min'              => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'        => 'Las contraseñas no coinciden.',
        ]);

        $user = auth()->user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'La contraseña actual no es correcta.'
            ]);
        }

        $user->update([
            'password' => \Hash::make($request->password)
        ]);

        return redirect()->route('profile.show')
            ->with('success', '✅ Contraseña actualizada correctamente');
    }
}
