<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'courses' => Course::count(),
            'lessons' => Lesson::count(),
            'exercises' => Exercise::count(),
        ];

        $latestUsers = User::latest()->take(5)->get();
        $recentCourses = Course::latest()->take(5)->get();

        return view('admin.index', compact('stats', 'latestUsers', 'recentCourses'));
    }

    // Courses
    public function courses()
    {
        $courses = Course::withCount('lessons')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function createCourse()
    {
        return view('admin.courses.create');
    }

    public function storeCourse(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|string',
            'category' => 'required|string',
            'difficulty' => 'required|in:Básico,Intermedio,Avanzado',
        ]);

        $data['slug'] = Str::slug($data['title']);
        Course::create($data);

        return redirect()->route('admin.courses')->with('success', 'Curso creado correctamente');
    }

    public function editCourse(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function updateCourse(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|string',
            'category' => 'required|string',
            'difficulty' => 'required|in:Básico,Intermedio,Avanzado',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $course->update($data);

        return redirect()->route('admin.courses')->with('success', 'Curso actualizado');
    }

    // Lessons
    public function lessons(Course $course)
    {
        $lessons = $course->lessons()->withCount('exercises')->orderBy('order')->get();
        return view('admin.lessons.index', compact('course', 'lessons'));
    }

    public function createLesson(Course $course)
    {
        return view('admin.lessons.create', compact('course'));
    }

    public function storeLesson(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'required|integer',
        ]);

        $course->lessons()->create($data);

        return redirect()->route('admin.lessons', $course)->with('success', 'Lección creada');
    }

    public function editLesson(Course $course, Lesson $lesson)
    {
        return view('admin.lessons.edit', compact('course', 'lesson'));
    }

    public function updateLesson(Request $request, Course $course, Lesson $lesson)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'required|integer',
        ]);

        $lesson->update($data);

        return redirect()->route('admin.lessons', $course)->with('success', 'Lección actualizada');
    }

    // Exercises
    public function editExercise(Lesson $lesson)
    {
        $exercise = $lesson->exercise;
        if (!$exercise) {
            $exercise = new Exercise(['lesson_id' => $lesson->id]);
        }
        return view('admin.exercises.edit', compact('lesson', 'exercise'));
    }

    public function updateExercise(Request $request, Lesson $lesson)
    {
        $data = $request->validate([
            'instructions' => 'required|string',
            'starter_code' => 'nullable|string',
            'solution_code' => 'required|string',
            'expected_output' => 'required|string',
            'hints' => 'nullable|string',
        ]);

        $lesson->exercise()->updateOrCreate(['lesson_id' => $lesson->id], $data);

        return redirect()->route('admin.lessons', $lesson->course_id)->with('success', 'Ejercicio actualizado');
    }

    // Users
    public function users()
    {
        $users = User::with('level')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function togglePremium(User $user)
    {
        $user->update(['is_premium' => !$user->is_premium]);
        return back()->with('success', 'Estado premium actualizado');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminarte a ti mismo');
        }
        $user->delete();
        return back()->with('success', 'Usuario eliminado');
    }
}
