@extends('admin.layout')
@section('breadcrumb')
    <a href="{{ route('admin.users') }}" 
       class="hover:text-white">Usuarios</a> / 
    {{ $user->name }}
@endsection
@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <a href="{{ route('admin.users') }}"
           class="text-gray-400 hover:text-white text-sm mb-2 
                  inline-block">
            ← Volver a usuarios
        </a>
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-gradient-to-br 
                        from-blue-500 to-purple-600 flex items-center 
                        justify-center text-xl font-black">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-2xl font-black">{{ $user->name }}</h1>
                <p class="text-gray-400 text-sm">{{ $user->email }}</p>
            </div>
        </div>
    </div>
    <div class="flex gap-3">
        <form method="POST" 
              action="{{ route('admin.users.toggle-premium', $user) }}">
            @csrf @method('PUT')
            <button type="submit"
                    class="px-4 py-2 text-sm rounded-xl transition
                        {{ $user->is_premium 
                            ? 'bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500/30' 
                            : 'bg-gray-800 text-gray-400 hover:bg-gray-700' }}">
                💎 {{ $user->is_premium ? 'Quitar Premium' : 'Dar Premium' }}
            </button>
        </form>
        <form method="POST" 
              action="{{ route('admin.users.toggle-admin', $user) }}">
            @csrf @method('PUT')
            <button type="submit"
                    class="px-4 py-2 text-sm rounded-xl transition
                        {{ $user->is_admin 
                            ? 'bg-red-500/20 text-red-400 hover:bg-red-500/30' 
                            : 'bg-gray-800 text-gray-400 hover:bg-gray-700' }}">
                ⚙️ {{ $user->is_admin ? 'Quitar Admin' : 'Hacer Admin' }}
            </button>
        </form>
        <form method="POST" 
              action="{{ route('admin.users.reset-progress', $user) }}"
              onsubmit="return confirm('¿Reiniciar TODO el progreso? No se puede deshacer.')">
            @csrf
            <button type="submit"
                    class="px-4 py-2 bg-orange-500/20 hover:bg-orange-500/30 
                           text-orange-400 rounded-xl text-sm transition">
                🔄 Reiniciar progreso
            </button>
        </form>
        @if($user->id !== auth()->id())
        <form method="POST" 
              action="{{ route('admin.users.destroy', $user) }}"
              onsubmit="return confirm('¿Eliminar usuario permanentemente?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="px-4 py-2 bg-red-600/20 hover:bg-red-600/40 
                           text-red-400 rounded-xl text-sm transition">
                🗑️ Eliminar
            </button>
        </form>
        @endif
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 text-center">
        <p class="text-2xl font-black text-blue-400">{{ $user->xp }}</p>
        <p class="text-gray-500 text-xs mt-1">XP Total</p>
    </div>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 text-center">
        <p class="text-2xl font-black text-orange-400">
            🔥 {{ $user->streak_days }}
        </p>
        <p class="text-gray-500 text-xs mt-1">Racha actual</p>
    </div>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 text-center">
        <p class="text-2xl font-black text-green-400">
            {{ $completedLessons->count() }}
        </p>
        <p class="text-gray-500 text-xs mt-1">Lecciones</p>
    </div>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 text-center">
        <p class="text-2xl font-black text-purple-400">
            {{ $user->level?->name ?? 'Sin nivel' }}
        </p>
        <p class="text-gray-500 text-xs mt-1">Nivel</p>
    </div>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 text-center">
        <p class="text-2xl font-black text-yellow-400">
            {{ $user->userAchievements->count() }}
        </p>
        <p class="text-gray-500 text-xs mt-1">Logros</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Course progress --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
        <h2 class="font-bold text-white mb-4">📚 Progreso por curso</h2>
        @if($coursesProgress->isEmpty())
        <p class="text-gray-500 text-sm">Sin progreso aún</p>
        @else
        <div class="space-y-3">
            @foreach($coursesProgress as $cp)
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-300 flex items-center gap-2">
                        {{ $cp['course']->icon }} {{ $cp['course']->title }}
                    </span>
                    <span class="{{ $cp['percent'] === 100 
                        ? 'text-green-400' 
                        : 'text-blue-400' }} font-bold text-xs">
                        {{ $cp['completed'] }}/{{ $cp['total'] }} 
                        ({{ $cp['percent'] }}%)
                    </span>
                </div>
                <div class="w-full bg-gray-800 rounded-full h-1.5">
                    <div class="h-1.5 rounded-full
                        {{ $cp['percent'] === 100 
                            ? 'bg-green-500' 
                            : 'bg-blue-500' }}"
                         style="width: {{ $cp['percent'] }}%">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Achievements --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
        <h2 class="font-bold text-white mb-4">🏆 Logros obtenidos</h2>
        @if($user->userAchievements->isEmpty())
        <p class="text-gray-500 text-sm">Sin logros aún</p>
        @else
        <div class="grid grid-cols-2 gap-2">
            @foreach($user->userAchievements as $ua)
            <div class="flex items-center gap-2 p-2 bg-gray-800 rounded-lg">
                <span class="text-xl">
                    {{ $ua->achievement->icon }}
                </span>
                <div>
                    <p class="text-xs font-bold text-white">
                        {{ $ua->achievement->name }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ \Carbon\Carbon::parse($ua->earned_at)
                            ->format('d/m/Y') }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- Recent activity --}}
<div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-6">
    <h2 class="font-bold text-white mb-4">📋 Lecciones completadas</h2>
    @if($completedLessons->isEmpty())
    <p class="text-gray-500 text-sm">Sin actividad aún</p>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-gray-500 text-left border-b 
                           border-gray-800">
                    <th class="pb-3 font-medium">Lección</th>
                    <th class="pb-3 font-medium">Curso</th>
                    <th class="pb-3 font-medium">XP ganado</th>
                    <th class="pb-3 font-medium">Completada</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @foreach($completedLessons->take(15) as $progress)
                <tr>
                    <td class="py-2.5 text-gray-300">
                        {{ $progress->lesson?->title ?? 'N/A' }}
                    </td>
                    <td class="py-2.5 text-gray-400">
                        {{ $progress->lesson?->course?->title ?? 'N/A' }}
                    </td>
                    <td class="py-2.5 text-blue-400 font-bold">
                        +{{ $progress->xp_earned }} XP
                    </td>
                    <td class="py-2.5 text-gray-500">
                        {{ $progress->completed_at 
                            ? \Carbon\Carbon::parse($progress->completed_at)
                                ->format('d/m/Y H:i') 
                            : 'N/A' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- Exercise attempts --}}
<div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
    <h2 class="font-bold text-white mb-4">
        💻 Últimos intentos de ejercicios
    </h2>
    @if($attempts->isEmpty())
    <p class="text-gray-500 text-sm">Sin intentos aún</p>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-gray-500 text-left border-b border-gray-800">
                    <th class="pb-3 font-medium">Ejercicio</th>
                    <th class="pb-3 font-medium">Resultado</th>
                    <th class="pb-3 font-medium">Código enviado</th>
                    <th class="pb-3 font-medium">Fecha</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @foreach($attempts as $attempt)
                <tr>
                    <td class="py-2.5 text-gray-300">
                        {{ $attempt->exercise?->lesson?->title ?? 'N/A' }}
                    </td>
                    <td class="py-2.5">
                        @if($attempt->is_correct)
                        <span class="px-2 py-0.5 bg-green-500/20 
                                     text-green-400 rounded-full text-xs">
                            ✅ Correcto
                        </span>
                        @else
                        <span class="px-2 py-0.5 bg-red-500/20 
                                     text-red-400 rounded-full text-xs">
                            ❌ Incorrecto
                        </span>
                        @endif
                    </td>
                    <td class="py-2.5">
                        <code class="text-xs text-gray-400 bg-gray-800 
                                     px-2 py-1 rounded font-mono">
                            {{ Str::limit($attempt->submitted_code, 40) }}
                        </code>
                    </td>
                    <td class="py-2.5 text-gray-500 text-xs">
                        {{ \Carbon\Carbon::parse($attempt->attempted_at)
                            ->format('d/m/Y H:i') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

@endsection
