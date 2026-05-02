<x-app-layout>
<div class="p-6 max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-black text-white mb-1">📚 Todos los cursos</h1>
        <p class="text-gray-400">
            Aprende a tu ritmo con nuestros cursos interactivos
        </p>
    </div>

    {{-- Search and filters --}}
    <form method="GET" action="{{ route('courses.index') }}"
          id="search-form">

        <div class="flex flex-col lg:flex-row gap-4 mb-6">

            {{-- Search input --}}
            <div class="relative flex-1">
                <span class="absolute left-4 top-1/2 -translate-y-1/2
                             text-gray-400 text-lg">🔍</span>
                <input type="text"
                       name="search"
                       id="search-input"
                       value="{{ $search }}"
                       placeholder="Buscar cursos..."
                       autocomplete="off"
                       class="w-full bg-gray-900 border border-gray-700
                              rounded-xl pl-11 pr-4 py-3 text-white
                              placeholder-gray-500 focus:outline-none
                              focus:border-blue-500 transition text-sm">
                @if($search)
                <a href="{{ route('courses.index', array_filter(['level' => $levelFilter, 'status' => $statusFilter])) }}"
                   class="absolute right-4 top-1/2 -translate-y-1/2
                          text-gray-500 hover:text-white transition text-lg">
                    ✕
                </a>
                @endif
            </div>

            {{-- Level filter --}}
            <select name="level"
                    onchange="document.getElementById('search-form').submit()"
                    class="bg-gray-900 border border-gray-700 rounded-xl
                           px-4 py-3 text-white focus:outline-none
                           focus:border-blue-500 transition text-sm
                           min-w-[160px]">
                <option value="">Todos los niveles</option>
                @foreach($levels as $level)
                <option value="{{ $level->id }}"
                    {{ $levelFilter == $level->id ? 'selected' : '' }}>
                    {{ $level->icon }} {{ $level->name }}
                </option>
                @endforeach
            </select>

            {{-- Status filter --}}
            <select name="status"
                    onchange="document.getElementById('search-form').submit()"
                    class="bg-gray-900 border border-gray-700 rounded-xl
                           px-4 py-3 text-white focus:outline-none
                           focus:border-blue-500 transition text-sm
                           min-w-[180px]">
                <option value="">Todos los estados</option>
                <option value="no-iniciados"
                    {{ $statusFilter === 'no-iniciados' ? 'selected' : '' }}>
                    ⭕ No iniciados
                </option>
                <option value="en-progreso"
                    {{ $statusFilter === 'en-progreso' ? 'selected' : '' }}>
                    🔄 En progreso
                </option>
                <option value="completados"
                    {{ $statusFilter === 'completados' ? 'selected' : '' }}>
                    ✅ Completados
                </option>
            </select>

            {{-- Search button --}}
            <button type="submit"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-500
                           text-white font-bold rounded-xl transition
                           whitespace-nowrap">
                Buscar
            </button>
        </div>

        {{-- Active filters display --}}
        @if($search || $levelFilter || $statusFilter)
        <div class="flex items-center gap-3 mb-4 flex-wrap">
            <span class="text-gray-400 text-sm">
                {{ $totalResults }} resultado(s) encontrado(s)
            </span>
            @if($search)
            <span class="flex items-center gap-2 px-3 py-1 bg-blue-600/20
                         border border-blue-500/30 text-blue-400 rounded-full
                         text-xs font-medium">
                🔍 "{{ $search }}"
                <a href="{{ route('courses.index', array_filter(['level' => $levelFilter, 'status' => $statusFilter])) }}"
                   class="hover:text-white transition">✕</a>
            </span>
            @endif
            @if($levelFilter)
            @php $selectedLevel = $levels->find($levelFilter); @endphp
            @if($selectedLevel)
            <span class="flex items-center gap-2 px-3 py-1 bg-purple-600/20
                         border border-purple-500/30 text-purple-400
                         rounded-full text-xs font-medium">
                {{ $selectedLevel->icon }} {{ $selectedLevel->name }}
                <a href="{{ route('courses.index', array_filter(['search' => $search, 'status' => $statusFilter])) }}"
                   class="hover:text-white transition">✕</a>
            </span>
            @endif
            @endif
            @if($statusFilter)
            <span class="flex items-center gap-2 px-3 py-1 bg-green-600/20
                         border border-green-500/30 text-green-400
                         rounded-full text-xs font-medium">
                {{ $statusFilter }}
                <a href="{{ route('courses.index', array_filter(['search' => $search, 'level' => $levelFilter])) }}"
                   class="hover:text-white transition">✕</a>
            </span>
            @endif
            <a href="{{ route('courses.index') }}"
               class="text-xs text-gray-500 hover:text-gray-300
                      underline transition">
                Limpiar todo
            </a>
        </div>
        @endif

    </form>

    {{-- Results --}}
    @if($courses->isEmpty())
    <div class="text-center py-20">
        <div class="text-6xl mb-4">🔍</div>
        <h2 class="text-xl font-bold text-white mb-2">
            No encontramos cursos
        </h2>
        <p class="text-gray-400 mb-6">
            Intenta con otros términos de búsqueda o limpia los filtros
        </p>
        <a href="{{ route('courses.index') }}"
           class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white
                  font-bold rounded-xl transition">
            Ver todos los cursos
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @foreach($courses as $course)
        @php
            $pct = $course->progress_percent ?? 0;
            $isComplete = $pct >= 100;
            $inProgress = $pct > 0 && $pct < 100;
        @endphp
        <div class="bg-gray-900 border rounded-2xl overflow-hidden
                    hover:border-blue-500/50 transition-all duration-300
                    hover:shadow-lg hover:shadow-blue-500/10
                    {{ $isComplete ? 'border-green-500/30' : 'border-gray-700/50' }}">

            {{-- Card header --}}
            <div class="p-6 pb-4">
                <div class="flex items-start justify-between mb-4">
                    <span class="text-4xl">{{ $course->icon }}</span>
                    <div class="flex flex-col items-end gap-2">
                        {{-- Level badge --}}
                        <span class="px-2 py-1 bg-gray-800 text-gray-400
                                     rounded-full text-xs font-medium">
                            {{ $course->level?->icon }}
                            {{ $course->level?->name ?? 'Sin nivel' }}
                        </span>
                        {{-- Status badge --}}
                        @if($isComplete)
                        <span class="px-2 py-1 bg-green-500/20 text-green-400
                                     rounded-full text-xs font-medium">
                            ✅ Completado
                        </span>
                        @elseif($inProgress)
                        <span class="px-2 py-1 bg-blue-500/20 text-blue-400
                                     rounded-full text-xs font-medium">
                            🔄 En progreso
                        </span>
                        @else
                        <span class="px-2 py-1 bg-gray-700 text-gray-500
                                     rounded-full text-xs font-medium">
                            ⭕ No iniciado
                        </span>
                        @endif
                    </div>
                </div>

                <h3 class="text-lg font-bold text-white mb-2 leading-tight">
                    {{ $course->title }}
                </h3>
                <p class="text-gray-400 text-sm leading-relaxed line-clamp-2 mb-4">
                    {{ $course->description }}
                </p>

                {{-- Stats row --}}
                <div class="flex items-center gap-4 text-xs text-gray-500 mb-4">
                    <span>📖 {{ $course->lessons->count() }} lecciones</span>
                    <span>⭐ {{ $course->lessons->sum('xp_reward') }} XP</span>
                </div>

                {{-- Progress bar --}}
                <div class="mb-2">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-500">Progreso</span>
                        <span class="{{ $isComplete ? 'text-green-400' : 'text-blue-400' }} font-medium">
                            {{ $pct }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-800 rounded-full h-2">
                        <div class="h-2 rounded-full transition-all duration-500
                            {{ $isComplete ? 'bg-green-500' : 'bg-blue-500' }}"
                             style="width: {{ $pct }}%">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card footer --}}
            <div class="px-6 pb-5">
                <a href="{{ route('courses.show', $course->slug) }}"
                   class="block w-full text-center py-2.5 rounded-xl
                          font-bold text-sm transition-all
                          {{ $isComplete
                              ? 'bg-green-500/20 hover:bg-green-500/30 text-green-400 border border-green-500/30'
                              : ($inProgress
                                  ? 'bg-blue-600 hover:bg-blue-500 text-white'
                                  : 'bg-gray-800 hover:bg-gray-700 text-white border border-gray-700') }}">
                    {{ $isComplete ? '🏆 Ver curso' : ($inProgress ? 'Continuar →' : 'Iniciar curso →') }}
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>

{{-- Live search with JS --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('search-input');
    const form  = document.getElementById('search-form');
    let timeout = null;
    input.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(function() { form.submit(); }, 500);
    });
});
</script>

</x-app-layout>
