@extends('admin.layout')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-3xl font-bold">Cursos</h2>
        <p class="text-slate-400">Gestiona los cursos de la plataforma</p>
    </div>
    <a href="{{ route('admin.courses.create') }}" class="bg-primary text-on-primary-container font-bold px-6 py-3 rounded-xl hover:opacity-90 transition-opacity">
        + Nuevo Curso
    </a>
</div>

<div class="bg-surface rounded-2xl border border-slate-800 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-slate-800/50 text-slate-400 text-xs font-bold uppercase">
            <tr>
                <th class="px-6 py-4">Imagen</th>
                <th class="px-6 py-4">Título</th>
                <th class="px-6 py-4">Categoría</th>
                <th class="px-6 py-4">Lecciones</th>
                <th class="px-6 py-4">Dificultad</th>
                <th class="px-6 py-4">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800 text-sm">
            @foreach($courses as $course)
            <tr class="hover:bg-slate-800/20 transition-colors">
                <td class="px-6 py-4">
                    <img src="{{ $course->image_url ?? 'https://placehold.co/100x60/1a1f2f/acc7ff?text=CodePath' }}" class="w-20 h-12 object-cover rounded-lg border border-slate-700">
                </td>
                <td class="px-6 py-4 font-semibold">{{ $course->title }}</td>
                <td class="px-6 py-4">{{ $course->category }}</td>
                <td class="px-6 py-4 text-slate-400">{{ $course->lessons_count }} lecciones</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs {{ $course->difficulty == 'Básico' ? 'bg-green-500/10 text-green-400' : ($course->difficulty == 'Intermedio' ? 'bg-yellow-500/10 text-yellow-400' : 'bg-red-500/10 text-red-400') }}">
                        {{ $course->difficulty }}
                    </span>
                </td>
                <td class="px-6 py-4 flex gap-4">
                    <a href="{{ route('admin.courses.edit', $course) }}" class="text-primary hover:underline">Editar</a>
                    <a href="{{ route('admin.lessons', $course) }}" class="text-secondary hover:underline">Lecciones</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
