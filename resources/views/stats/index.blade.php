<x-app-layout>
<div class="p-6 max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-black text-white mb-1">
            📊 Mis Estadísticas
        </h1>
        <p class="text-gray-400">
            Tu progreso detallado en InitCode
        </p>
    </div>

    {{-- Top stats grid --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 
                    text-center">
            <p class="text-4xl font-black text-blue-400 mb-1">
                {{ $user->xp }}
            </p>
            <p class="text-gray-400 text-xs uppercase tracking-widest">
                XP Total
            </p>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 
                    text-center">
            <p class="text-4xl font-black text-green-400 mb-1">
                {{ $totalLessonsCompleted }}
            </p>
            <p class="text-gray-400 text-xs uppercase tracking-widest">
                Lecciones
            </p>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 
                    text-center">
            <p class="text-4xl font-black text-orange-400 mb-1">
                {{ $bestStreak }}
            </p>
            <p class="text-gray-400 text-xs uppercase tracking-widest">
                Mejor racha
            </p>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 
                    text-center">
            <p class="text-4xl font-black text-purple-400 mb-1">
                {{ $accuracy }}%
            </p>
            <p class="text-gray-400 text-xs uppercase tracking-widest">
                Precisión
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        {{-- XP por día --}}
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="font-bold text-white">⭐ XP ganado por día</h2>
                    <p class="text-gray-500 text-xs mt-0.5">Últimos 14 días</p>
                </div>
                @php $totalXpPeriod = array_sum(array_column($xpByDay, 'xp')); @endphp
                <div class="text-right">
                    <p class="text-blue-400 font-black text-xl">{{ $totalXpPeriod }}</p>
                    <p class="text-gray-500 text-xs">XP total</p>
                </div>
            </div>

            @php $maxXp = max(array_column($xpByDay, 'xp')) ?: 1; @endphp

            <div class="relative h-36 mb-2">
                {{-- Y axis grid lines --}}
                <div class="absolute inset-0 flex flex-col justify-between 
                            pointer-events-none">
                    @for($g = 0; $g < 4; $g++)
                    <div class="w-full border-t border-gray-800/60"></div>
                    @endfor
                </div>
                
                {{-- Bars --}}
                <div class="absolute inset-0 flex items-end gap-1 px-0">
                    @foreach($xpByDay as $day)
                    @php
                        $barHeight = $day['xp'] > 0 
                            ? max(6, (int) round(($day['xp'] / $maxXp) * 130))
                            : 2;
                        $isToday = $day['date'] === \Carbon\Carbon::now()->format('Y-m-d');
                        $hasData = $day['xp'] > 0;
                        $color = $isToday 
                            ? 'background: linear-gradient(to top, #059669, #34d399);'
                            : ($hasData 
                                ? 'background: linear-gradient(to top, #1d4ed8, #60a5fa);'
                                : 'background: rgba(55,65,81,0.4);');
                    @endphp
                    <div class="flex-1 flex flex-col items-center justify-end h-full 
                                group relative">
                        @if($hasData)
                        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 
                                    bg-gray-800 border border-gray-700 rounded px-1.5 py-0.5
                                    text-white whitespace-nowrap opacity-0 
                                    group-hover:opacity-100 transition z-10
                                    pointer-events-none"
                             style="font-size:10px; bottom: {{ $barHeight + 4 }}px;">
                            {{ $day['xp'] }}xp
                        </div>
                        @endif
                        <div class="w-full rounded-t-sm"
                             style="{{ $color }} height: {{ $barHeight }}px;">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- X axis labels --}}
            <div class="flex gap-1">
                @foreach($xpByDay as $day)
                @php $isToday = $day['date'] === \Carbon\Carbon::now()->format('Y-m-d'); @endphp
                <div class="flex-1 text-center">
                    <span class="text-gray-{{ $isToday ? '300' : '600' }} font-{{ $isToday ? 'bold' : 'normal' }}"
                          style="font-size: 9px;">
                        {{ $day['label'] }}
                    </span>
                </div>
                @endforeach
            </div>

            {{-- Legend --}}
            <div class="flex items-center gap-4 mt-3 pt-3 border-t border-gray-800">
                <div class="flex items-center gap-1.5">
                    <div class="w-3 h-3 rounded-sm"
                         style="background: linear-gradient(to top, #1d4ed8, #60a5fa)"></div>
                    <span class="text-gray-500 text-xs">XP ganado</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-3 h-3 rounded-sm"
                         style="background: linear-gradient(to top, #059669, #34d399)"></div>
                    <span class="text-gray-500 text-xs">Hoy</span>
                </div>
            </div>
        </div>

        {{-- Lecciones por día --}}
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="font-bold text-white">📚 Lecciones por día</h2>
                    <p class="text-gray-500 text-xs mt-0.5">Últimos 14 días</p>
                </div>
                @php $totalLessonsPeriod = array_sum(array_column($lessonsByDay, 'count')); @endphp
                <div class="text-right">
                    <p class="text-purple-400 font-black text-xl">{{ $totalLessonsPeriod }}</p>
                    <p class="text-gray-500 text-xs">lecciones</p>
                </div>
            </div>

            @php $maxL = max(array_column($lessonsByDay, 'count')) ?: 1; @endphp

            <div class="relative h-36 mb-2">
                <div class="absolute inset-0 flex flex-col justify-between 
                            pointer-events-none">
                    @for($g = 0; $g < 4; $g++)
                    <div class="w-full border-t border-gray-800/60"></div>
                    @endfor
                </div>
                
                <div class="absolute inset-0 flex items-end gap-1 px-0">
                    @foreach($lessonsByDay as $day)
                    @php
                        $barHeight = $day['count'] > 0 
                            ? max(6, (int) round(($day['count'] / $maxL) * 130))
                            : 2;
                        $isToday = $day['date'] === \Carbon\Carbon::now()->format('Y-m-d');
                        $hasData = $day['count'] > 0;
                        $color = $isToday 
                            ? 'background: linear-gradient(to top, #c2410c, #fb923c);'
                            : ($hasData 
                                ? 'background: linear-gradient(to top, #7e22ce, #c084fc);'
                                : 'background: rgba(55,65,81,0.4);');
                    @endphp
                    <div class="flex-1 flex flex-col items-center justify-end h-full 
                                group relative">
                        @if($hasData)
                        <div class="absolute left-1/2 -translate-x-1/2 
                                    bg-gray-800 border border-gray-700 rounded px-1.5 py-0.5
                                    text-white whitespace-nowrap opacity-0 
                                    group-hover:opacity-100 transition z-10
                                    pointer-events-none"
                             style="font-size:10px; bottom: {{ $barHeight + 4 }}px;">
                            {{ $day['count'] }}
                        </div>
                        @endif
                        <div class="w-full rounded-t-sm"
                             style="{{ $color }} height: {{ $barHeight }}px;">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-1">
                @foreach($lessonsByDay as $day)
                @php $isToday = $day['date'] === \Carbon\Carbon::now()->format('Y-m-d'); @endphp
                <div class="flex-1 text-center">
                    <span class="text-gray-{{ $isToday ? '300' : '600' }} font-{{ $isToday ? 'bold' : 'normal' }}"
                          style="font-size: 9px;">
                        {{ $day['label'] }}
                    </span>
                </div>
                @endforeach
            </div>

            <div class="flex items-center gap-4 mt-3 pt-3 border-t border-gray-800">
                <div class="flex items-center gap-1.5">
                    <div class="w-3 h-3 rounded-sm"
                         style="background: linear-gradient(to top, #7e22ce, #c084fc)"></div>
                    <span class="text-gray-500 text-xs">Lecciones</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-3 h-3 rounded-sm"
                         style="background: linear-gradient(to top, #c2410c, #fb923c)"></div>
                    <span class="text-gray-500 text-xs">Hoy</span>
                </div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        {{-- Nivel actual y siguiente --}}
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
            <h2 class="font-bold text-white mb-4">⬆️ Nivel actual</h2>
            
            <div class="text-center mb-4">
                <span class="text-5xl">{{ $user->level?->icon ?? '🌱' }}</span>
                <p class="text-xl font-black text-white mt-2">
                    {{ $user->level?->name ?? 'Sin nivel' }}
                </p>
                <p class="text-blue-400 font-bold text-lg">
                    {{ $user->xp }} XP
                </p>
            </div>

            @if($nextLevel)
            <div>
                <div class="flex justify-between text-xs text-gray-400 mb-1">
                    <span>Progreso al siguiente nivel</span>
                    <span>{{ $xpProgress }}%</span>
                </div>
                <div class="w-full bg-gray-800 rounded-full h-2 mb-2">
                    <div class="h-2 bg-blue-500 rounded-full"
                         style="width: {{ $xpProgress }}%"></div>
                </div>
                <p class="text-xs text-gray-500 text-center">
                    Faltan {{ $xpToNextLevel }} XP para 
                    {{ $nextLevel->icon }} {{ $nextLevel->name }}
                </p>
            </div>
            @else
            <div class="text-center">
                <p class="text-green-400 text-sm font-bold">
                    🏆 ¡Nivel máximo alcanzado!
                </p>
            </div>
            @endif
        </div>

        {{-- Ejercicios --}}
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
            <h2 class="font-bold text-white mb-4">💻 Ejercicios</h2>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">Intentados</span>
                    <span class="font-bold text-white">
                        {{ $totalExercisesAttempted }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">Correctos</span>
                    <span class="font-bold text-green-400">
                        {{ $totalExercisesCorrect }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">Incorrectos</span>
                    <span class="font-bold text-red-400">
                        {{ $totalExercisesAttempted - $totalExercisesCorrect }}
                    </span>
                </div>
                
                <div class="pt-2 border-t border-gray-800">
                    <div class="flex justify-between text-xs text-gray-400 mb-1">
                        <span>Precisión general</span>
                        <span class="font-bold 
                            {{ $accuracy >= 80 
                                ? 'text-green-400' 
                                : ($accuracy >= 50 
                                    ? 'text-yellow-400' 
                                    : 'text-red-400') }}">
                            {{ $accuracy }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-800 rounded-full h-3">
                        <div class="h-3 rounded-full
                            {{ $accuracy >= 80 
                                ? 'bg-green-500' 
                                : ($accuracy >= 50 
                                    ? 'bg-yellow-500' 
                                    : 'bg-red-500') }}"
                             style="width: {{ $accuracy }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actividad general --}}
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
            <h2 class="font-bold text-white mb-5">📅 Actividad</h2>
            
            <div class="space-y-4">
                
                {{-- Days learning --}}
                <div class="flex justify-between items-center p-3 
                            bg-gray-800/50 rounded-xl">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">📖</span>
                        <span class="text-gray-300 text-sm font-medium">
                            Días aprendiendo
                        </span>
                    </div>
                    <span class="font-black text-white text-xl">
                        {{ (int) $daysLearning }}
                    </span>
                </div>

                {{-- Current streak --}}
                <div class="flex justify-between items-center p-3 
                            bg-orange-500/10 border border-orange-500/20 
                            rounded-xl">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">🔥</span>
                        <span class="text-gray-300 text-sm font-medium">
                            Racha actual
                        </span>
                    </div>
                    <span class="font-black text-orange-400 text-xl">
                        {{ (int) $user->streak_days }}
                    </span>
                </div>

                {{-- Best streak --}}
                <div class="flex justify-between items-center p-3 
                            bg-yellow-500/10 border border-yellow-500/20 
                            rounded-xl">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">⚡</span>
                        <span class="text-gray-300 text-sm font-medium">
                            Mejor racha
                        </span>
                    </div>
                    <span class="font-black text-yellow-400 text-xl">
                        {{ (int) $bestStreak }}
                    </span>
                </div>



            </div>
        </div>

    </div>

    {{-- Progreso por cursos --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 mb-6">
        <h2 class="font-bold text-white mb-6">📚 Progreso por curso</h2>
        
        @if($coursesProgress->isEmpty())
        <p class="text-gray-500 text-center py-4">
            Aún no has iniciado ningún curso
        </p>
        @else
        <div class="space-y-4">
            @foreach($coursesProgress as $cp)
            <div>
                <div class="flex items-center gap-3 mb-1.5">
                    <span class="text-lg">{{ $cp['course']->icon }}</span>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-white">
                                {{ $cp['course']->title }}
                            </span>
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-gray-400">
                                    {{ $cp['completed'] }}/{{ $cp['total'] }} lecciones
                                </span>
                                <span class="text-sm font-bold w-12 text-right
                                    {{ $cp['percent'] === 100 
                                        ? 'text-green-400' 
                                        : 'text-blue-400' }}">
                                    {{ $cp['percent'] }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full bg-gray-800 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all
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

    {{-- Mapa de calor de actividad mensual --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
        <h2 class="font-bold text-white mb-2">🗓️ Actividad este mes</h2>
        <p class="text-gray-500 text-xs mb-5">
            {{ \Carbon\Carbon::now()->format('F Y') }}
        </p>
        
        @php
            $today = \Carbon\Carbon::now();
            $startOfMonth = $today->copy()->startOfMonth();
            $activeDates = \App\Models\UserProgress::where('user_id', auth()->id())
                ->whereMonth('completed_at', $today->month)
                ->whereYear('completed_at', $today->year)
                ->selectRaw('DATE(completed_at) as day, COUNT(*) as count')
                ->groupBy('day')
                ->pluck('count', 'day')
                ->toArray();
        @endphp
        
        <div class="flex flex-wrap gap-1.5">
            {{-- Empty cells for days before month start --}}
            @for($i = 0; $i < ($startOfMonth->dayOfWeek === 0 ? 6 : $startOfMonth->dayOfWeek - 1); $i++)
            <div class="w-8 h-8"></div>
            @endfor
            
            @for($day = 1; $day <= $today->daysInMonth; $day++)
            @php
                $date = $today->copy()->setDay($day)->format('Y-m-d');
                $count = $activeDates[$date] ?? 0;
                $isFuture = $day > $today->day;
                $isToday = $day === $today->day;
            @endphp
            <div class="w-8 h-8 rounded-lg flex items-center justify-center 
                        text-xs font-bold transition-all
                {{ $isFuture 
                    ? 'bg-gray-800 text-gray-700' 
                    : ($isToday 
                        ? 'ring-2 ring-blue-500 ' . ($count > 0 ? 'bg-green-500 text-black' : 'bg-gray-800 text-white')
                        : ($count > 0 
                            ? 'bg-green-500/80 text-black' 
                            : 'bg-gray-800 text-gray-600')) }}"
                 title="{{ $date }}: {{ $count }} lecciones">
                {{ $day }}
            </div>
            @endfor
        </div>
        
        <div class="flex items-center gap-4 mt-4 text-xs text-gray-500">
            <div class="flex items-center gap-1.5">
                <div class="w-3 h-3 rounded bg-gray-800"></div>
                Sin actividad
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-3 h-3 rounded bg-green-500/80"></div>
                Activo
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-3 h-3 rounded ring-2 ring-blue-500 bg-gray-800"></div>
                Hoy
            </div>
        </div>
    </div>

</div>
</x-app-layout>
