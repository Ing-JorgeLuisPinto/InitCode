@extends('admin.layout')
@section('breadcrumb') Cursos @endsection
@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black">📚 Cursos</h1>
        <p class="text-gray-400 text-sm mt-1">
            {{ $courses->count() }} cursos en total
        </p>
    </div>
    <a href="{{ route('admin.courses.create') }}"
       class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white 
              font-bold rounded-xl transition text-sm">
        + Nuevo curso
    </a>
</div>

<div class="space-y-3">
    @foreach($courses as $course)
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 
                hover:border-gray-700 transition">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4 flex-1">
                <span class="text-3xl flex-shrink-0">{{ $course->icon }}</span>
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-1">
                        <h3 class="font-bold text-white">
                            {{ $course->title }}
                        </h3>
                        <span class="text-xs text-gray-500">
                            Orden: {{ $course->order }}
                        </span>
                        @if($course->is_premium)
                        <span class="px-2 py-0.5 bg-yellow-500/20 
                                     text-yellow-400 rounded-full text-xs">
                            💎 Premium
                        </span>
                        @endif
                    </div>
                    <p class="text-gray-400 text-sm">
                        {{ $course->description }}
                    </p>
                    <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                        <span>
                            {{ $course->level?->icon }} 
                            {{ $course->level?->name ?? 'Sin nivel' }}
                        </span>
                        <span>
                            📖 {{ $course->lessons->count() }} lecciones
                        </span>
                        <span>
                            💻 {{ $course->lessons->sum(fn($l) => $l->exercises->count()) }} ejercicios
                        </span>
                        <span>
                            ⭐ {{ $course->lessons->sum('xp_reward') }} XP total
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 ml-4">
                <a href="{{ route('admin.lessons', $course) }}"
                   class="px-4 py-2 bg-blue-600/20 hover:bg-blue-600/40 
                          text-blue-400 rounded-xl text-sm transition 
                          font-medium whitespace-nowrap">
                    📖 Ver lecciones
                </a>
                <a href="{{ route('admin.courses.edit', $course) }}"
                   class="px-4 py-2 bg-gray-800 hover:bg-gray-700 
                          text-white rounded-xl text-sm transition">
                    ✏️ Editar
                </a>
                <form method="POST"
                      action="{{ route('admin.courses.destroy', $course) }}"
                      onsubmit="return confirm('¿Eliminar este curso y todas sus lecciones?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-red-600/20 hover:bg-red-600/40 
                                   text-red-400 rounded-xl text-sm transition">
                        🗑️
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
