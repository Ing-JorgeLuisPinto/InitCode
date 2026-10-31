<?php
namespace App\Http\Controllers;

use App\Models\{Course, Lesson, Exercise, Achievement, User, Level, UserProgress, UserExerciseAttempt, UserAchievement};
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller implements HasMiddleware
{
    // ── MIDDLEWARE ──────────────────────────────────────────────
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(function ($request, $next) {
                if (!$request->user() || !$request->user()->is_admin) {
                    abort(403, 'Acceso denegado');
                }
                return $next($request);
            }),
        ];
    }

    // ── SLUG HELPER ─────────────────────────────────────────────
    private function generateUniqueSlug(string $modelClass, string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        if (empty($slug)) {
            $slug = 'item';
        }

        $originalSlug = $slug;
        $count = 1;

        while ($modelClass::where('slug', $slug)
            ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $count++;
            $slug = "{$originalSlug}-{$count}";
        }

        return $slug;
    }

    // ── DASHBOARD ───────────────────────────────────────────────
    public function index()
    {
        $stats = [
            'total_users'     => User::count(),
            'total_courses'   => Course::count(),
            'total_lessons'   => Lesson::count(),
            'total_exercises' => Exercise::count(),
            'top_users'       => User::with('level')->orderBy('xp', 'desc')->take(5)->get(),
            'recent_users'    => User::latest()->take(5)->get(),
        ];
        $courses      = Course::with(['lessons', 'level'])->orderBy('order')->get();
        $achievements = Achievement::all();
        $levels       = Level::all();

        return view('admin.index', compact('stats', 'courses', 'achievements', 'levels'));
    }

    // ── COURSES ─────────────────────────────────────────────────
    public function createCourse()
    {
        $levels = Level::all();
        return view('admin.courses.create', compact('levels'));
    }

    public function storeCourse(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'icon'        => 'required|string|max:10',
            'order'       => 'required|integer|min:1',
            'level_id'    => 'required|exists:levels,id',
            'is_premium'  => 'boolean',
        ]);

        $data['slug']       = $this->generateUniqueSlug(Course::class, $data['title']);
        $data['is_premium'] = $request->boolean('is_premium');

        Course::create($data);

        return redirect()->route('admin.index', ['tab' => 'courses'])
            ->with('success', '✅ Curso creado correctamente');
    }

    public function editCourse(Course $course)
    {
        $levels = Level::all();
        return view('admin.courses.edit', compact('course', 'levels'));
    }

    public function updateCourse(Request $request, Course $course)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'icon'        => 'required|string|max:10',
            'order'       => 'required|integer|min:1',
            'level_id'    => 'required|exists:levels,id',
            'is_premium'  => 'boolean',
        ]);

        if ($course->title !== $data['title']) {
            $data['slug'] = $this->generateUniqueSlug(Course::class, $data['title'], $course->id);
        }
        $data['is_premium'] = $request->boolean('is_premium');

        $course->update($data);

        return redirect()->route('admin.index', ['tab' => 'courses'])
            ->with('success', '✅ Curso actualizado correctamente');
    }

    public function destroyCourse(Course $course)
    {
        DB::transaction(function () use ($course) {
            foreach ($course->lessons as $lesson) {
                foreach ($lesson->exercises as $exercise) {
                    UserExerciseAttempt::where('exercise_id', $exercise->id)->delete();
                    $exercise->delete();
                }
                UserProgress::where('lesson_id', $lesson->id)->delete();
                $lesson->delete();
            }
            $course->delete();
        });

        return redirect()->route('admin.index', ['tab' => 'courses'])
            ->with('success', '🗑️ Curso eliminado correctamente');
    }

    // ── LESSONS ─────────────────────────────────────────────────
    public function createLesson(Course $course)
    {
        return view('admin.lessons.create', compact('course'));
    }

    public function storeLesson(Request $request, Course $course)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:255',
            'content'         => 'required|string',
            'order'           => 'required|integer|min:1',
            'xp_reward'       => 'required|integer|min:1',
            'type'            => 'required|in:reading,exercise,challenge',
            'instructions'    => 'nullable|string',
            'starter_code'    => 'nullable|string',
            'solution_code'   => 'nullable|string',
            'expected_output' => 'nullable|string',
            'exercise_xp'     => 'nullable|integer|min:0',
        ]);

        $lessonData = [
            'course_id' => $course->id,
            'title'     => $data['title'],
            'content'   => $data['content'],
            'order'     => $data['order'],
            'xp_reward' => $data['xp_reward'],
            'type'      => $data['type'],
            'slug'      => $this->generateUniqueSlug(Lesson::class, $data['title']),
        ];

        DB::transaction(function () use ($lessonData, $request) {
            $lesson = Lesson::create($lessonData);

            if ($request->filled('instructions')) {
                Exercise::create([
                    'lesson_id'       => $lesson->id,
                    'instructions'    => $request->instructions,
                    'starter_code'    => $request->starter_code ?? '',
                    'solution_code'   => $request->solution_code ?? '',
                    'expected_output' => $request->expected_output ?? '',
                    'xp_reward'       => $request->exercise_xp ?? $lesson->xp_reward,
                ]);
            }
        });

        return redirect()->route('admin.index', ['tab' => 'courses'])
            ->with('success', '✅ Lección creada correctamente');
    }

    public function editLesson(Lesson $lesson)
    {
        $course = $lesson->course;
        $exercise = $lesson->exercises()->first();
        return view('admin.lessons.edit', compact('lesson', 'course', 'exercise'));
    }

    public function updateLesson(Request $request, Lesson $lesson)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:255',
            'content'         => 'required|string',
            'order'           => 'required|integer|min:1',
            'xp_reward'       => 'required|integer|min:1',
            'type'            => 'required|in:reading,exercise,challenge',
            'instructions'    => 'nullable|string',
            'starter_code'    => 'nullable|string',
            'solution_code'   => 'nullable|string',
            'expected_output' => 'nullable|string',
            'exercise_xp'     => 'nullable|integer|min:0',
        ]);

        $lessonData = [
            'title'     => $data['title'],
            'content'   => $data['content'],
            'order'     => $data['order'],
            'xp_reward' => $data['xp_reward'],
            'type'      => $data['type'],
        ];

        if ($lesson->title !== $data['title']) {
            $lessonData['slug'] = $this->generateUniqueSlug(Lesson::class, $data['title'], $lesson->id);
        }

        DB::transaction(function () use ($lesson, $lessonData, $request) {
            $lesson->update($lessonData);

            if ($request->filled('instructions')) {
                $lesson->exercises()->updateOrCreate(
                    ['lesson_id' => $lesson->id],
                    [
                        'instructions'    => $request->instructions,
                        'starter_code'    => $request->starter_code ?? '',
                        'solution_code'   => $request->solution_code ?? '',
                        'expected_output' => $request->expected_output ?? '',
                        'xp_reward'       => $request->exercise_xp ?? $lesson->xp_reward,
                    ]
                );
            }
        });

        return redirect()->route('admin.index', ['tab' => 'courses'])
            ->with('success', '✅ Lección actualizada correctamente');
    }

    public function destroyLesson(Lesson $lesson)
    {
        DB::transaction(function () use ($lesson) {
            foreach ($lesson->exercises as $exercise) {
                UserExerciseAttempt::where('exercise_id', $exercise->id)->delete();
                $exercise->delete();
            }
            UserProgress::where('lesson_id', $lesson->id)->delete();
            $lesson->delete();
        });

        return redirect()->route('admin.index', ['tab' => 'courses'])
            ->with('success', '🗑️ Lección eliminada');
    }

    // ── ACHIEVEMENTS ────────────────────────────────────────────
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
            'name', 'description', 'icon', 'condition_type', 'condition_value'
        ]));

        return redirect()->route('admin.index', ['tab' => 'achievements'])
            ->with('success', '✅ Logro creado correctamente');
    }

    public function editAchievement(Achievement $achievement)
    {
        return view('admin.achievements.edit', compact('achievement'));
    }

    public function updateAchievement(Request $request, Achievement $achievement)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'required|string',
            'icon'            => 'required|string|max:10',
            'condition_type'  => 'required|string',
            'condition_value' => 'required|integer|min:1',
        ]);

        $achievement->update($request->only([
            'name', 'description', 'icon', 'condition_type', 'condition_value'
        ]));

        return redirect()->route('admin.index', ['tab' => 'achievements'])
            ->with('success', '✅ Logro actualizado correctamente');
    }

    public function destroyAchievement(Achievement $achievement)
    {
        DB::transaction(function () use ($achievement) {
            UserAchievement::where('achievement_id', $achievement->id)->delete();
            $achievement->delete();
        });

        return redirect()->route('admin.index', ['tab' => 'achievements'])
            ->with('success', '🗑️ Logro eliminado');
    }

    // ── USERS ───────────────────────────────────────────────────
    public function users(Request $request)
    {
        $search = $request->input('search');
        $query = User::with('level')->orderBy('xp', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(20)->withQueryString();

        return view('admin.users', compact('users', 'search'));
    }

    public function makeAdmin(User $user)
    {
        $user->update(['is_admin' => true]);
        return back()->with('success', '✅ Usuario ' . $user->name . ' ahora es administrador');
    }

    public function removeAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', '❌ No puedes quitarte el rol de admin a ti mismo');
        }
        $user->update(['is_admin' => false]);
        return back()->with('success', '✅ Rol de admin removido');
    }
}
