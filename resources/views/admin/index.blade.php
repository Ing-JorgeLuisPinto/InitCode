@extends('admin.layout')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-3xl font-black text-white bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent">Dashboard Admin</h2>
        <p class="text-slate-400 text-sm">Resumen general y administración de la plataforma</p>
    </div>
</div>

<!-- Navigation Tabs -->
<div class="flex gap-2 border-b border-slate-800 mb-8 pb-px overflow-x-auto">
    <button onclick="switchTab('tab-dashboard')" data-tab="tab-dashboard" class="tab-btn px-5 py-3 font-bold border-b-2 text-sm transition-all focus:outline-none border-blue-500 text-blue-400 bg-blue-600/10 rounded-t-xl flex items-center gap-2">
        📊 Resumen
    </button>
    <button onclick="switchTab('tab-courses')" data-tab="tab-courses" class="tab-btn px-5 py-3 font-bold border-b-2 text-sm transition-all focus:outline-none border-transparent text-gray-400 hover:text-white hover:bg-slate-800/30 rounded-t-xl flex items-center gap-2">
        📚 Cursos y Lecciones
    </button>
    <button onclick="switchTab('tab-achievements')" data-tab="tab-achievements" class="tab-btn px-5 py-3 font-bold border-b-2 text-sm transition-all focus:outline-none border-transparent text-gray-400 hover:text-white hover:bg-slate-800/30 rounded-t-xl flex items-center gap-2">
        🏆 Logros
    </button>
</div>

<!-- ==================== TAB 1: RESUMEN ==================== -->
<div id="tab-dashboard" class="tab-content space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="p-6 rounded-2xl bg-gray-900 border border-gray-800 hover:border-gray-700 transition">
            <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-2">Usuarios Registrados</p>
            <p class="text-3xl font-black text-white">{{ $stats['total_users'] }}</p>
        </div>
        <div class="p-6 rounded-2xl bg-gray-900 border border-gray-800 hover:border-gray-700 transition">
            <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-2">Cursos Disponibles</p>
            <p class="text-3xl font-black text-white">{{ $stats['total_courses'] }}</p>
        </div>
        <div class="p-6 rounded-2xl bg-gray-900 border border-gray-800 hover:border-gray-700 transition">
            <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-2">Lecciones Creadas</p>
            <p class="text-3xl font-black text-white">{{ $stats['total_lessons'] }}</p>
        </div>
        <div class="p-6 rounded-2xl bg-gray-900 border border-gray-800 hover:border-gray-700 transition">
            <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-2">Ejercicios Activos</p>
            <p class="text-3xl font-black text-white">{{ $stats['total_exercises'] }}</p>
        </div>
    </div>

    <!-- Users Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Users -->
        <div class="bg-gray-900 rounded-2xl border border-gray-800 overflow-hidden">
            <div class="p-6 border-b border-gray-800 flex justify-between items-center">
                <h3 class="font-bold text-white">Usuarios Recientes</h3>
                <a href="{{ route('admin.users') }}" class="text-xs text-blue-400 hover:underline">Ver todos →</a>
            </div>
            <div class="divide-y divide-gray-800/60">
                @foreach($stats['recent_users'] as $user)
                <div class="p-4 flex items-center justify-between hover:bg-gray-800/10 transition flex-row">
                    <div>
                        <p class="font-bold text-sm text-gray-200">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                    <span class="text-xs px-2.5 py-1 rounded-lg bg-gray-800 text-gray-400">
                        {{ $user->created_at->diffForHumans() }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Users -->
        <div class="bg-gray-900 rounded-2xl border border-gray-800 overflow-hidden">
            <div class="p-6 border-b border-gray-800">
                <h3 class="font-bold text-white">Top 5 Usuarios (XP)</h3>
            </div>
            <div class="divide-y divide-gray-800/60">
                @foreach($stats['top_users'] as $user)
                <div class="p-4 flex items-center justify-between hover:bg-gray-800/10 transition flex-row">
                    <div>
                        <p class="font-bold text-sm text-gray-200">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">Nivel: {{ $user->level->name ?? 'N/A' }}</p>
                    </div>
                    <span class="text-xs px-3 py-1 font-bold rounded-lg bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        {{ $user->xp }} XP
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- ==================== TAB 2: CURSOS Y LECCIONES ==================== -->
<div id="tab-courses" class="tab-content space-y-6 hidden">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-white">Gestión de Cursos</h3>
            <p class="text-gray-400 text-sm">Administra los cursos, lecciones asociadas y ejercicios prácticos.</p>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl transition text-sm flex items-center gap-1.5 shadow-lg shadow-blue-600/15">
            ➕ Nuevo Curso
        </a>
    </div>

    <!-- Courses List -->
    <div class="space-y-4">
        @foreach($courses as $course)
        <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden hover:border-gray-700 transition">
            <!-- Course Header -->
            <div class="p-6 bg-gray-950/40 border-b border-gray-800/60 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <span class="text-4xl p-2 bg-gray-800 rounded-xl leading-none">{{ $course->icon }}</span>
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <h4 class="text-lg font-bold text-white">{{ $course->title }}</h4>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-800 text-gray-400">
                                Orden: {{ $course->order }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                {{ $course->level->icon ?? '⭐' }} {{ $course->level->name ?? 'N/A' }}
                            </span>
                            @if($course->is_premium)
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 flex items-center gap-1">
                                💎 Premium
                            </span>
                            @endif
                        </div>
                        <p class="text-gray-400 text-sm max-w-2xl">{{ $course->description }}</p>
                    </div>
                </div>

                <!-- Course Actions -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.courses.edit', $course) }}" class="px-3.5 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-xl text-sm font-semibold transition flex items-center gap-1">
                        ✏️ Editar
                    </a>
                    <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('¿Estás seguro?')" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3.5 py-2 bg-red-600/10 hover:bg-red-600/20 text-red-400 border border-red-500/20 rounded-xl text-sm font-semibold transition flex items-center gap-1">
                            🗑️ Eliminar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Lessons Section inside Course -->
            <div class="p-6 bg-gray-900/50">
                <div class="flex items-center justify-between mb-4">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-gray-400">Lecciones ({{ $course->lessons->count() }})</h5>
                    <a href="{{ route('admin.lessons.create', $course) }}" class="px-3 py-1.5 bg-blue-600/10 hover:bg-blue-600/20 text-blue-400 border border-blue-500/20 rounded-lg text-xs font-bold transition flex items-center gap-1">
                        ➕ Nueva Lección
                    </a>
                </div>

                @if($course->lessons->isEmpty())
                <div class="text-center py-6 border border-dashed border-gray-800 rounded-xl">
                    <p class="text-gray-500 text-sm">Este curso aún no tiene lecciones creadas.</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-800 text-gray-500 text-xs font-bold uppercase">
                                <th class="pb-3 w-16">Orden</th>
                                <th class="pb-3">Lección</th>
                                <th class="pb-3">Tipo</th>
                                <th class="pb-3">Recompensa</th>
                                <th class="pb-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800/40 text-sm">
                            @foreach($course->lessons->sortBy('order') as $lesson)
                            <tr class="hover:bg-gray-800/10 transition-colors">
                                <td class="py-3 font-semibold text-gray-400">{{ $lesson->order }}</td>
                                <td class="py-3">
                                    <div class="font-bold text-gray-200">{{ $lesson->title }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-md">{{ Str::limit($lesson->content, 60) }}</div>
                                </td>
                                <td class="py-3">
                                    @php
                                        $typeColors = [
                                            'reading' => 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20',
                                            'exercise' => 'bg-purple-500/10 text-purple-400 border border-purple-500/20',
                                            'challenge' => 'bg-amber-500/10 text-amber-400 border border-amber-500/20'
                                        ];
                                        $typeNames = [
                                            'reading' => '📖 Lectura',
                                            'exercise' => '💻 Ejercicio',
                                            'challenge' => '⚡ Desafío'
                                        ];
                                        $typeClass = $typeColors[$lesson->type] ?? 'bg-gray-800 text-gray-400';
                                        $typeName = $typeNames[$lesson->type] ?? $lesson->type;
                                    @endphp
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $typeClass }}">
                                        {{ $typeName }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <span class="text-xs font-semibold text-gray-300">{{ $lesson->xp_reward }} XP</span>
                                </td>
                                <td class="py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.lessons.edit', $lesson) }}" class="px-2.5 py-1 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-lg text-xs font-semibold transition">
                                            ✏️ Editar
                                        </a>
                                        <form method="POST" action="{{ route('admin.lessons.destroy', $lesson) }}" onsubmit="return confirm('¿Estás seguro?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1 bg-red-600/10 hover:bg-red-600/20 text-red-400 rounded-lg text-xs font-semibold transition">
                                                🗑️ Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- ==================== TAB 3: LOGROS ==================== -->
<div id="tab-achievements" class="tab-content space-y-6 hidden">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-white">Gestión de Logros</h3>
            <p class="text-gray-400 text-sm">Administra los reconocimientos que los usuarios pueden desbloquear en base a su actividad.</p>
        </div>
        <a href="{{ route('admin.achievements.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl transition text-sm flex items-center gap-1.5 shadow-lg shadow-blue-600/15">
            ➕ Nuevo Logro
        </a>
    </div>

    <!-- Achievements Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($achievements as $achievement)
        <div class="bg-gray-900 border border-gray-800 hover:border-gray-700 rounded-2xl p-6 transition flex flex-col justify-between gap-4">
            <div class="space-y-3">
                <div class="flex items-start justify-between">
                    <span class="text-4xl p-2 bg-gray-800 rounded-xl leading-none">{{ $achievement->icon }}</span>
                    
                    <!-- Achievement Actions -->
                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('admin.achievements.edit', $achievement) }}" class="px-2.5 py-1 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-lg text-xs font-semibold transition">
                            ✏️
                        </a>
                        <form method="POST" action="{{ route('admin.achievements.destroy', $achievement) }}" onsubmit="return confirm('¿Estás seguro?')" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2.5 py-1 bg-red-600/10 hover:bg-red-600/20 text-red-400 rounded-lg text-xs font-semibold transition">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>

                <div class="space-y-1">
                    <h4 class="font-bold text-white text-base">{{ $achievement->name }}</h4>
                    <p class="text-gray-400 text-sm leading-relaxed">{{ $achievement->description }}</p>
                </div>
            </div>

            <!-- Achievement Rules -->
            <div class="pt-3 border-t border-gray-800/60 flex items-center justify-between text-xs">
                <span class="text-gray-500">
                    Condición:
                    <span class="font-semibold text-blue-400">
                        {{ $achievement->condition_type }} &ge; {{ $achievement->condition_value }}
                    </span>
                </span>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Simple Tab Switcher JavaScript -->
<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.getElementById(tabId).classList.remove('hidden');
        document.querySelectorAll('.tab-btn').forEach(el => {
            el.classList.remove('border-blue-500', 'text-blue-400', 'bg-blue-600/10');
            el.classList.add('border-transparent', 'text-gray-400');
        });
        const activeBtn = document.querySelector(`[onclick="switchTab('${tabId}')"]`);
        if (activeBtn) {
            activeBtn.classList.add('border-blue-500', 'text-blue-400', 'bg-blue-600/10');
            activeBtn.classList.remove('border-transparent', 'text-gray-400');
        }
        localStorage.setItem('admin_active_tab', tabId);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const tabParam = urlParams.get('tab');
        const activeTab = (tabParam ? 'tab-' + tabParam : null) || localStorage.getItem('admin_active_tab') || 'tab-dashboard';
        switchTab(activeTab);
    });
</script>
@endsection
