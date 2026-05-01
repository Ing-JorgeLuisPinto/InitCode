@extends('admin.layout')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-3xl font-bold">Lecciones de: {{ $course->title }}</h2>
        <p class="text-slate-400">Gestiona el contenido del curso</p>
    </div>
    <div class="flex gap-4">
        <a href="{{ route('admin.courses') }}" class="px-6 py-3 border border-slate-800 rounded-xl font-bold hover:bg-slate-800 transition-colors">
            Volver a Cursos
        </a>
        <a href="{{ route('admin.lessons.create', $course) }}" class="bg-secondary text-on-secondary font-bold px-6 py-3 rounded-xl hover:opacity-90 transition-opacity">
            + Nueva Lección
        </a>
    </div>
</div>

<div class="bg-surface rounded-2xl border border-slate-800 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-slate-800/50 text-slate-400 text-xs font-bold uppercase">
            <tr>
                <th class="px-6 py-4">Orden</th>
                <th class="px-6 py-4">Título</th>
                <th class="px-6 py-4">Ejercicio</th>
                <th class="px-6 py-4">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800 text-sm">
            @foreach($lessons as $lesson)
            <tr class="hover:bg-slate-800/20 transition-colors">
                <td class="px-6 py-4 font-bold text-primary">{{ $lesson->order }}</td>
                <td class="px-6 py-4 font-semibold">{{ $lesson->title }}</td>
                <td class="px-6 py-4">
                    @if($lesson->exercises_count > 0)
                        <span class="text-green-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">check_circle</span> Configurado
                        </span>
                    @else
                        <span class="text-yellow-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">warning</span> Pendiente
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 flex gap-4">
                    <a href="{{ route('admin.lessons.edit', [$course, $lesson]) }}" class="text-primary hover:underline">Editar Contenido</a>
                    <a href="{{ route('admin.exercises.edit', $lesson) }}" class="text-secondary hover:underline">Gestionar Ejercicio</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
