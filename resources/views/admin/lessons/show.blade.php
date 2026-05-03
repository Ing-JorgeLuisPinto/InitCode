@extends('admin.layout')
@section('breadcrumb')
    <a href="{{ route('admin.courses') }}" 
       class="hover:text-white">Cursos</a> / 
    <a href="{{ route('admin.lessons', $lesson->course) }}" 
       class="hover:text-white">{{ $lesson->course->title }}</a> / 
    {{ $lesson->title }}
@endsection
@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <a href="{{ route('admin.lessons', $lesson->course) }}"
           class="text-gray-400 hover:text-white text-sm mb-2 
                  inline-block">
            ← Volver a lecciones
        </a>
        <h1 class="text-2xl font-black">
            {{ $lesson->course->icon }} {{ $lesson->title }}
        </h1>
        <div class="flex items-center gap-3 mt-2">
            <span class="px-2 py-1 bg-gray-800 text-gray-400 
                         rounded-full text-xs">
                {{ $lesson->type }}
            </span>
            <span class="px-2 py-1 bg-blue-600/20 text-blue-400 
                         rounded-full text-xs">
                +{{ $lesson->xp_reward }} XP
            </span>
            <span class="px-2 py-1 bg-gray-800 text-gray-400 
                         rounded-full text-xs">
                Orden: {{ $lesson->order }}
            </span>
        </div>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.lessons.edit', $lesson) }}"
           class="px-4 py-2 bg-gray-800 hover:bg-gray-700 
                  text-white rounded-xl text-sm transition">
            ✏️ Editar lección
        </a>
        <form method="POST" 
              action="{{ route('admin.lessons.destroy', $lesson) }}"
              onsubmit="return confirm('¿Eliminar esta lección?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="px-4 py-2 bg-red-600/20 hover:bg-red-600/40 
                           text-red-400 rounded-xl text-sm transition">
                🗑️ Eliminar
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Stats --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
        <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">
            Completaciones
        </p>
        <p class="text-3xl font-black text-green-400">
            {{ $completionCount }}
        </p>
        <p class="text-gray-500 text-xs mt-1">usuarios completaron</p>
    </div>

    @if($exercise)
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
        <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">
            Intentos totales
        </p>
        <p class="text-3xl font-black text-blue-400">
            {{ $attemptStats['total'] }}
        </p>
        <p class="text-gray-500 text-xs mt-1">intentos de ejercicio</p>
    </div>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
        <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">
            Tasa de éxito
        </p>
        <p class="text-3xl font-black text-purple-400">
            {{ $attemptStats['total'] > 0 
                ? round(($attemptStats['correct'] / $attemptStats['total']) * 100) 
                : 0 }}%
        </p>
        <p class="text-gray-500 text-xs mt-1">respuestas correctas</p>
    </div>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Lesson content --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
        <h2 class="font-bold text-white mb-4">📖 Contenido de la lección</h2>
        <div class="prose prose-invert prose-sm max-w-none 
                    text-gray-300 leading-relaxed">
            {!! $lesson->content !!}
        </div>
    </div>

    {{-- Exercise --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-bold text-white">💻 Ejercicio</h2>
            <a href="{{ route('admin.exercise.edit', $lesson) }}"
               class="px-3 py-1.5 bg-blue-600/20 hover:bg-blue-600/40 
                      text-blue-400 rounded-lg text-xs transition">
                {{ $exercise ? '✏️ Editar' : '+ Crear ejercicio' }}
            </a>
        </div>

        @if($exercise)
        <div class="space-y-4">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">
                    Instrucciones
                </p>
                <p class="text-gray-300 text-sm bg-gray-800 rounded-lg p-3">
                    {{ $exercise->instructions }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">
                    Código inicial (starter_code)
                </p>
                <pre class="text-sm text-gray-300 font-mono bg-gray-800 
                            rounded-lg p-3 overflow-x-auto whitespace-pre-wrap">{{ $exercise->starter_code ?: '(vacío)' }}</pre>
            </div>

            <div>
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">
                    Solución correcta
                </p>
                <pre class="text-sm text-green-300 font-mono bg-green-500/10 
                            border border-green-500/20 rounded-lg p-3 
                            overflow-x-auto whitespace-pre-wrap">{{ $exercise->solution_code }}</pre>
            </div>

            <div>
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">
                    Output esperado
                </p>
                <pre class="text-sm text-blue-300 font-mono bg-blue-500/10 
                            border border-blue-500/20 rounded-lg p-3 
                            overflow-x-auto">{{ $exercise->expected_output }}</pre>
            </div>

            @if($exercise->hints)
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">
                    Pistas
                </p>
                <div class="space-y-2">
                    @foreach((array)$exercise->hints as $hint)
                    <div class="text-sm text-yellow-300 bg-yellow-500/10 
                                border border-yellow-500/20 rounded-lg p-2">
                        💡 {{ $hint }}
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="flex items-center justify-between pt-2 
                        border-t border-gray-800">
                <span class="text-xs text-gray-500">
                    XP recompensa:
                    <span class="text-blue-400 font-bold">
                        +{{ $exercise->xp_reward }} XP
                    </span>
                </span>
                <form method="POST" 
                      action="{{ route('admin.exercise.destroy', $exercise) }}"
                      onsubmit="return confirm('¿Eliminar ejercicio?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="text-xs text-red-400 hover:text-red-300 
                                   transition">
                        🗑️ Eliminar ejercicio
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="text-center py-8">
            <p class="text-gray-500 text-sm mb-3">
                Esta lección no tiene ejercicio
            </p>
            <a href="{{ route('admin.exercise.edit', $lesson) }}"
               class="px-4 py-2 bg-blue-600 hover:bg-blue-500 
                      text-white rounded-xl text-sm font-bold transition">
                + Crear ejercicio
            </a>
        </div>
        @endif
    </div>
</div>

@endsection
