<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-10">
        <!-- Welcome Banner -->
        <section class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h2 class="font-display text-4xl">¡Hola, {{ explode(' ', $user->name)[0] }}! 👋</h2>
                    <span class="bg-secondary-container/20 text-secondary border border-secondary/30 px-3 py-1 rounded-full text-sm font-bold flex items-center gap-1">
                        {{ $user->level->name ?? 'Principiante' }}
                    </span>
                </div>
                <p class="text-lg text-slate-400">
                    @if($user->streak_days > 0)
                        Llevas {{ $user->streak_days }} {{ $user->streak_days == 1 ? 'día' : 'días' }} seguidos aprendiendo. ¡Sigue así! 🔥
                    @else
                        ¡Empieza hoy tu racha de aprendizaje! 🚀
                    @endif
                </p>
            </div>
            <div class="hidden lg:block text-right">
                <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mb-1">Tu progreso semanal</p>
                <div class="flex gap-2">
                    @php $days = ['L', 'M', 'X', 'J', 'V', 'S', 'D']; @endphp
                    @foreach($days as $day)
                    <div class="w-8 h-8 rounded {{ $loop->index < ($user->streak_days % 7) ? 'bg-secondary text-on-secondary' : 'bg-surface-container border border-outline-variant text-slate-500' }} flex items-center justify-center font-bold text-xs">
                        {{ $day }}
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Stats Grid -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- XP Card -->
            <div class="bg-surface-container border border-outline-variant p-6 rounded-2xl glow-blue transition-all hover:scale-[1.02]">
                <div class="flex justify-between items-start mb-4">
                    <span class="material-symbols-outlined text-primary p-2 bg-primary/10 rounded-lg" style="font-variation-settings: 'FILL' 1;">stars</span>
                </div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Puntos totales</p>
                <h3 class="text-3xl font-bold text-primary">✨ {{ number_format($user->xp) }} XP</h3>
            </div>
            <!-- Streak Card -->
            <div class="bg-surface-container border border-outline-variant p-6 rounded-2xl glow-orange transition-all hover:scale-[1.02]">
                <div class="flex justify-between items-start mb-4">
                    <span class="material-symbols-outlined text-tertiary p-2 bg-tertiary/10 rounded-lg" style="font-variation-settings: 'FILL' 1;">local_fire_department</span>
                </div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Racha actual</p>
                <h3 class="text-3xl font-bold text-tertiary">🔥 {{ $user->streak_days }} días</h3>
            </div>
            <!-- Lessons Card -->
            <div class="bg-surface-container border border-outline-variant p-6 rounded-2xl glow-green transition-all hover:scale-[1.02]">
                <div class="flex justify-between items-start mb-4">
                    <span class="material-symbols-outlined text-secondary p-2 bg-secondary/10 rounded-lg" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Lecciones completadas</p>
                <h3 class="text-3xl font-bold text-secondary">✅ {{ $completedCount }}</h3>
            </div>
        </section>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- "Continúa aprendiendo" Section -->
            <div class="xl:col-span-2 space-y-6">
                <h4 class="text-2xl font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">play_circle</span>
                    Continúa aprendiendo
                </h4>
                
                @if($nextLesson)
                <div class="relative overflow-hidden bg-surface-container-high border border-[#4F8EF7]/30 rounded-2xl p-8 group">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-primary/10 blur-[100px] rounded-full group-hover:bg-primary/20 transition-all duration-700"></div>
                    <div class="relative z-10 flex flex-col md:flex-row gap-8 items-center">
                        <div class="w-full md:w-1/3">
                            <div class="aspect-video rounded-xl overflow-hidden border border-outline-variant bg-surface-container-low flex items-center justify-center">
                                <img src="https://images.unsplash.com/photo-1587620962725-abab7fe55159?auto=format&fit=crop&q=80&w=1000" alt="{{ $nextLesson->title }}" class="w-full h-full object-cover opacity-60 group-hover:scale-110 transition-transform duration-700">
                            </div>
                        </div>
                        <div class="flex-1 space-y-4">
                            <span class="bg-primary/20 text-primary px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest">{{ $nextLesson->course->title }}</span>
                            <h3 class="text-4xl font-bold">{{ $nextLesson->title }}</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs font-bold uppercase tracking-widest text-slate-400">
                                    <span>Progreso del curso</span>
                                    <span>{{ round($nextLesson->course->getProgressForUser($user)) }}%</span>
                                </div>
                                <div class="w-full h-3 bg-surface-container-lowest rounded-full overflow-hidden border border-outline-variant">
                                    <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition-all duration-1000" style="width: {{ $nextLesson->course->getProgressForUser($user) }}%"></div>
                                </div>
                            </div>
                            <a href="{{ route('lessons.show', [$nextLesson->course->slug, $nextLesson->slug]) }}" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-primary-container to-blue-600 rounded-full font-bold text-white hover:shadow-[0_0_25px_rgba(79,142,247,0.4)] transition-all active:scale-95">
                                Continuar lección
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-surface-container border border-outline-variant rounded-2xl p-8 text-center space-y-4">
                    <div class="text-6xl">🏆</div>
                    <h3 class="text-2xl font-bold">¡Has completado todo el contenido!</h3>
                    <p class="text-slate-400">Vuelve pronto para nuevos cursos y desafíos.</p>
                </div>
                @endif
            </div>

            <!-- Recent Activity Section -->
            <div class="space-y-6">
                <h4 class="text-2xl font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-tertiary">history</span>
                    Actividad reciente
                </h4>
                <div class="bg-surface-container border border-outline-variant rounded-2xl overflow-hidden">
                    <div class="divide-y divide-[#1F2937]">
                        @forelse($recentProgress as $progress)
                        <div class="p-4 flex items-center gap-4 hover:bg-surface-container-high transition-colors">
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary text-sm">article</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold truncate">{{ $progress->lesson->title }}</p>
                                <p class="text-xs text-slate-500">{{ ($progress->completed_at ? \Carbon\Carbon::parse($progress->completed_at)->diffForHumans() : 'Recientemente') }}</p>
                            </div>
                            <div class="bg-primary/20 text-primary px-2 py-1 rounded text-[10px] font-bold">
                                +{{ $progress->xp_earned }} XP
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center text-slate-500 italic">No hay actividad reciente.</div>
                        @endforelse
                    </div>
                </div>

                <!-- AI Tutor Mini Promo -->
                <div class="bg-gradient-to-br from-indigo-900/40 to-surface-container border border-indigo-500/30 rounded-2xl p-6 relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 opacity-20">
                        <span class="material-symbols-outlined text-8xl text-indigo-400 group-hover:scale-110 transition-transform duration-500">smart_toy</span>
                    </div>
                    <h5 class="text-lg font-bold mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-400">bolt</span>
                        ¿Necesitas ayuda?
                    </h5>
                    <p class="text-sm text-slate-400 mb-4">Pregúntale a nuestro Tutor IA para una explicación personalizada.</p>
                    <a href="{{ route('tutor.index') }}" class="text-xs font-bold text-indigo-400 hover:text-indigo-300 flex items-center gap-1">
                        Hablar con CodeBot <span class="material-symbols-outlined text-xs">chevron_right</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
