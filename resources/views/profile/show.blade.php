<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-10">
        <!-- Profile Header -->
        <section class="bg-surface-container border border-outline-variant rounded-3xl p-10 flex flex-col md:flex-row items-center gap-10">
            <div class="relative">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-primary shadow-2xl">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=508ff8&color=fff&size=128" alt="{{ $user->name }}">
                </div>
                <div class="absolute -bottom-2 -right-2 bg-secondary text-on-secondary w-10 h-10 rounded-full flex items-center justify-center text-xl shadow-xl">
                    🔥
                </div>
            </div>
            <div class="flex-1 text-center md:text-left space-y-4">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <h1 class="text-4xl font-black text-on-surface">{{ $user->name }}</h1>
                    <span class="bg-primary/20 text-primary border border-primary/30 px-4 py-1 rounded-full text-sm font-bold">
                        {{ $user->level->name }} (Nivel {{ $user->level->level_number }})
                    </span>
                </div>
                <p class="text-on-surface-variant text-lg">Miembro desde {{ $user->created_at->format('M Y') }}</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-8 pt-2">
                    <div class="text-center md:text-left">
                        <p class="text-2xl font-black text-on-surface">{{ number_format($user->xp) }}</p>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Puntos Totales</p>
                    </div>
                    <div class="text-center md:text-left">
                        <p class="text-2xl font-black text-on-surface">{{ $user->streak_days }}</p>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Racha de Días</p>
                    </div>
                    <div class="text-center md:text-left">
                        <p class="text-2xl font-black text-on-surface">{{ $completedLessons }}</p>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Lecciones</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-3">
                <a href="{{ route('profile.edit') }}" class="px-8 py-3 bg-surface-container-high border border-outline-variant rounded-xl font-bold hover:bg-surface-container-highest transition-all text-center">
                    Editar Perfil
                </a>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Achievements -->
            <div class="lg:col-span-2 space-y-6">
                <h2 class="text-2xl font-bold flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary">emoji_events</span>
                    Logros Desbloqueados
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($allAchievements as $achievement)
                    <div class="bg-surface-container border border-outline-variant p-6 rounded-2xl flex flex-col items-center gap-4 text-center transition-all hover:scale-105 {{ $earnedIds->contains($achievement->id) ? '' : 'grayscale opacity-40' }}">
                        <div class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center text-4xl shadow-lg">
                            {{ $achievement->icon }}
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-sm text-on-surface">{{ $achievement->name }}</h4>
                            <p class="text-[10px] text-slate-500 leading-tight">{{ $achievement->description }}</p>
                        </div>
                        @if($earnedIds->contains($achievement->id))
                        <span class="text-[10px] bg-secondary/20 text-secondary px-2 py-0.5 rounded font-black uppercase">Conseguido</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Course Progress -->
            <div class="space-y-6">
                <h2 class="text-2xl font-bold flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">analytics</span>
                    Progreso de Cursos
                </h2>
                <div class="bg-surface-container border border-outline-variant rounded-3xl p-6 space-y-6">
                    @foreach($coursesProgress as $item)
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-on-surface truncate pr-2">{{ $item['course']->title }}</span>
                            <span class="text-xs font-bold text-primary">{{ $item['percent'] }}%</span>
                        </div>
                        <div class="w-full h-2 bg-surface-container-lowest rounded-full overflow-hidden border border-outline-variant">
                            <div class="h-full bg-primary rounded-full transition-all duration-1000" style="width: {{ $item['percent'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
