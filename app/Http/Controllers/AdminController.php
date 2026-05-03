<?php
namespace App\Http\Controllers;

use App\Models\{Course, Lesson, Exercise, User, Level, 
               UserProgress, UserExerciseAttempt, Achievement};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // ==================== DASHBOARD ====================

    public function index()
    {
        $stats = [
            'total_users'     => User::count(),
            'total_courses'   => Course::count(),
            'total_lessons'   => Lesson::count(),
            'total_exercises' => Exercise::count(),
            'premium_users'   => User::where('is_premium', true)->count(),
            'completions'     => UserProgress::count(),
            'attempts'        => UserExerciseAttempt::count(),
            'correct_attempts'=> UserExerciseAttempt::where('is_correct', true)->count(),
            'top_users'       => User::with('level')
                                    ->orderBy('xp', 'desc')
                                    ->take(5)->get(),
            'recent_users'    => User::latest()->take(5)->get(),
        ];

        $accuracy = $stats['attempts'] > 0
            ? round(($stats['correct_attempts'] / $stats['attempts']) * 100)
            : 0;
        $stats['accuracy'] = $accuracy;

        return view('admin.index', compact('stats'));
    }

    // ==================== COURSES ====================

    public function courses()
    {
        $courses = Course::with(['level', 'lessons.exercises'])
            ->orderBy('order')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function createCourse()
    {
        $levels = Level::all();
        return view('admin.courses.create', compact('levels'));
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'icon'        => 'required|string|max:10',
            'order'       => 'required|integer',
            'level_id'    => 'required|exists:levels,id',
        ]);

        Course::create([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'description' => $request->description,
            'icon'        => $request->icon,
            'order'       => $request->order,
            'level_id'    => $request->level_id,
            'is_premium'  => $request->boolean('is_premium'),
        ]);

        return redirect()->route('admin.courses')
            ->with('success', '✅ Curso creado correctamente');
    }

    public function editCourse(Course $course)
    {
        $levels = Level::all();
        return view('admin.courses.edit', compact('course', 'levels'));
    }

    public function updateCourse(Request $request, Course $course)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'icon'        => 'required|string|max:10',
            'order'       => 'required|integer',
            'level_id'    => 'required|exists:levels,id',
        ]);

        $course->update([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'description' => $request->description,
            'icon'        => $request->icon,
            'order'       => $request->order,
            'level_id'    => $request->level_id,
            'is_premium'  => $request->boolean('is_premium'),
        ]);

        return redirect()->route('admin.courses')
            ->with('success', '✅ Curso actualizado');
    }

    public function destroyCourse(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses')
            ->with('success', '🗑️ Curso eliminado');
    }

    // ==================== LESSONS ====================

    public function lessons(Course $course)
    {
        $lessons = $course->lessons()
            ->with('exercises')
            ->orderBy('order')
            ->get();
        return view('admin.lessons.index', 
            compact('course', 'lessons'));
    }

    public function createLesson(Course $course)
    {
        return view('admin.lessons.create', compact('course'));
    }

    public function storeLesson(Request $request, Course $course)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'order'     => 'required|integer',
            'xp_reward' => 'required|integer|min:1',
            'type'      => 'required|in:reading,exercise,challenge',
        ]);

        Lesson::create([
            'course_id'  => $course->id,
            'title'      => $request->title,
            'slug'       => Str::slug($request->title) . '-' . time(),
            'content'    => $request->content,
            'order'      => $request->order,
            'xp_reward'  => $request->xp_reward,
            'type'       => $request->type,
        ]);

        return redirect()->route('admin.lessons', $course)
            ->with('success', '✅ Lección creada');
    }

    public function showLesson(Lesson $lesson)
    {
        $lesson->load(['course', 'exercises']);
        $exercise = $lesson->exercises->first();
        
        $completionCount = UserProgress::where('lesson_id', $lesson->id)
            ->count();
        $attemptStats = [];
        if ($exercise) {
            $attemptStats = [
                'total'   => UserExerciseAttempt::where('exercise_id', $exercise->id)->count(),
                'correct' => UserExerciseAttempt::where('exercise_id', $exercise->id)
                                ->where('is_correct', true)->count(),
            ];
        }

        return view('admin.lessons.show', 
            compact('lesson', 'exercise', 'completionCount', 'attemptStats'));
    }

    public function editLesson(Lesson $lesson)
    {
        return view('admin.lessons.edit', compact('lesson'));
    }

    public function updateLesson(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'order'     => 'required|integer',
            'xp_reward' => 'required|integer|min:1',
            'type'      => 'required|in:reading,exercise,challenge',
        ]);

        $lesson->update([
            'title'     => $request->title,
            'slug'      => Str::slug($request->title) . '-' . $lesson->id,
            'content'   => $request->content,
            'order'     => $request->order,
            'xp_reward' => $request->xp_reward,
            'type'      => $request->type,
        ]);

        return redirect()->route('admin.lesson.show', $lesson)
            ->with('success', '✅ Lección actualizada');
    }

    public function destroyLesson(Lesson $lesson)
    {
        $course = $lesson->course;
        $lesson->delete();
        return redirect()->route('admin.lessons', $course)
            ->with('success', '🗑️ Lección eliminada');
    }

    // ==================== EXERCISES ====================

    public function editExercise(Lesson $lesson)
    {
        $exercise = $lesson->exercises()->first();
        return view('admin.exercises.edit', 
            compact('lesson', 'exercise'));
    }

    public function storeExercise(Request $request, Lesson $lesson)
    {
        $request->validate([
            'instructions'    => 'required|string',
            'solution_code'   => 'required|string',
            'expected_output' => 'required|string',
            'xp_reward'       => 'required|integer|min:1',
        ]);

        Exercise::updateOrCreate(
            ['lesson_id' => $lesson->id],
            [
                'instructions'    => $request->instructions,
                'starter_code'    => $request->starter_code ?? '',
                'solution_code'   => $request->solution_code,
                'expected_output' => $request->expected_output,
                'xp_reward'       => $request->xp_reward,
                'hints'           => $request->hints
                    ? json_decode($request->hints, true)
                    : null,
            ]
        );

        return redirect()->route('admin.lesson.show', $lesson)
            ->with('success', '✅ Ejercicio guardado');
    }

    public function updateExercise(Request $request, Exercise $exercise)
    {
        $exercise->update([
            'instructions'    => $request->instructions,
            'starter_code'    => $request->starter_code ?? '',
            'solution_code'   => $request->solution_code,
            'expected_output' => $request->expected_output,
            'xp_reward'       => $request->xp_reward,
            'hints'           => $request->hints
                ? json_decode($request->hints, true)
                : null,
        ]);

        return redirect()->route('admin.lesson.show', $exercise->lesson)
            ->with('success', '✅ Ejercicio actualizado');
    }

    public function destroyExercise(Exercise $exercise)
    {
        $lesson = $exercise->lesson;
        $exercise->delete();
        return redirect()->route('admin.lesson.show', $lesson)
            ->with('success', '🗑️ Ejercicio eliminado');
    }

    // ==================== USERS ====================

    public function users(Request $request)
    {
        $search = $request->input('search', '');
        $query = User::with('level')->orderBy('xp', 'desc');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $users = $query->paginate(20);
        return view('admin.users.index', compact('users', 'search'));
    }

    public function showUser(User $user)
    {
        $user->load(['level', 'userAchievements.achievement']);
        
        $completedLessons = UserProgress::where('user_id', $user->id)
            ->with('lesson.course')
            ->orderBy('completed_at', 'desc')
            ->get();

        $attempts = UserExerciseAttempt::where('user_id', $user->id)
            ->with('exercise.lesson.course')
            ->orderBy('attempted_at', 'desc')
            ->take(20)
            ->get();

        $coursesProgress = Course::with('lessons')->get()
            ->map(function($course) use ($user) {
                $total = $course->lessons->count();
                $completed = UserProgress::where('user_id', $user->id)
                    ->whereIn('lesson_id', $course->lessons->pluck('id'))
                    ->count();
                $completed = min($completed, $total);
                $percent = $total > 0
                    ? (int) min(100, round(($completed / $total) * 100))
                    : 0;
                return [
                    'course'    => $course,
                    'total'     => $total,
                    'completed' => $completed,
                    'percent'   => $percent,
                ];
            })->filter(fn($c) => $c['completed'] > 0)->values();

        return view('admin.users.show', compact(
            'user', 'completedLessons', 'attempts', 'coursesProgress'
        ));
    }

    public function togglePremium(User $user)
    {
        $user->update(['is_premium' => !$user->is_premium]);
        return back()->with('success', '✅ Estado premium actualizado');
    }

    public function toggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes modificar tu propio rol');
        }
        $user->update(['is_admin' => !$user->is_admin]);
        return back()->with('success', '✅ Rol de admin actualizado');
    }

    public function resetUserProgress(User $user)
    {
        UserProgress::where('user_id', $user->id)->delete();
        UserExerciseAttempt::where('user_id', $user->id)->delete();
        $user->update(['xp' => 0, 'streak_days' => 0]);
        return back()->with('success', '✅ Progreso del usuario reiniciado');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminarte a ti mismo');
        }
        $user->delete();
        return redirect()->route('admin.users')
            ->with('success', '🗑️ Usuario eliminado');
    }

    // ==================== ACHIEVEMENTS ====================

    public function achievements()
    {
        $achievements = Achievement::withCount('userAchievements')
            ->get();
        return view('admin.achievements.index', 
            compact('achievements'));
    }

    public function createAchievement()
    {
        return view('admin.achievements.create');
    }

    public function storeAchievement(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'required|string',
            'icon'            => 'required|string|max:10',
            'condition_type'  => 'required|string',
            'condition_value' => 'required|integer|min:1',
        ]);

        Achievement::create($request->only([
            'name', 'description', 'icon',
            'condition_type', 'condition_value'
        ]));

        return redirect()->route('admin.achievements')
            ->with('success', '✅ Logro creado');
    }

    public function editAchievement(Achievement $achievement)
    {
        return view('admin.achievements.edit', 
            compact('achievement'));
    }

    public function updateAchievement(
        Request $request, Achievement $achievement)
    {
        $achievement->update($request->only([
            'name', 'description', 'icon',
            'condition_type', 'condition_value'
        ]));

        return redirect()->route('admin.achievements')
            ->with('success', '✅ Logro actualizado');
    }

    public function destroyAchievement(Achievement $achievement)
    {
        $achievement->delete();
        return redirect()->route('admin.achievements')
            ->with('success', '🗑️ Logro eliminado');
    }
}
