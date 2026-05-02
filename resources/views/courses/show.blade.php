<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-12">
        <a href="{{ route('courses.index') }}" 
           class="inline-flex items-center gap-2 text-gray-400 hover:text-white 
                  transition mb-6 group">
            ← Volver a cursos
        </a>

        <!-- Hero Section -->
        <header class="relative overflow-hidden bg-surface-container border border-outline-variant rounded-3xl p-12 flex flex-col md:flex-row gap-12 items-center">
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-primary/10 blur-[120px] rounded-full"></div>
            <div class="w-full md:w-1/3 aspect-square rounded-2xl bg-surface-container-high border border-outline-variant flex items-center justify-center text-8xl shadow-2xl">
                @if(Str::contains($course->title, 'HTML')) 🌐 @elseif(Str::contains($course->title, 'Java')) ⚙️ @else 💡 @endif
            </div>
            <div class="flex-1 space-y-6 text-center md:text-left">
                <nav class="flex justify-center md:justify-start gap-2">
                    <span class="bg-primary-container text-on-primary-container px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest">{{ $course->level->name }}</span>
                </nav>
                <h1 class="text-5xl font-black text-on-surface">{{ $course->title }}</h1>
                <p class="text-xl text-on-surface-variant max-w-2xl">{{ $course->description }}</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-6 pt-4">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">school</span>
                        <span class="font-bold">{{ $course->lessons->count() }} lecciones</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">verified</span>
                        <span class="font-bold">Certificado disponible</span>
                    </div>
                </div>
            </div>
        </header>

        @php
            $courseLessonIds = $course->lessons->pluck('id');
            $totalLessonsCount = $courseLessonIds->count();

            $completedCount = 0;
            if (isset($completedLessons) && $completedLessons !== null) {
                if ($completedLessons instanceof \Illuminate\Support\Collection) {
                    $completedCount = $completedLessons->intersect($courseLessonIds)->count();
                } elseif (is_array($completedLessons)) {
                    $completedCount = count(
                        array_intersect($completedLessons, $courseLessonIds->toArray())
                    );
                }
            }

            $completedCount = min($completedCount, $totalLessonsCount);
            $completionPercent = $totalLessonsCount > 0
                ? (int) round(($completedCount / $totalLessonsCount) * 100)
                : 0;
            $completionPercent = min(100, $completionPercent);
            $isComplete = ($completedCount >= $totalLessonsCount && $totalLessonsCount > 0);
        @endphp

        {{-- Progress bar --}}
        <div class="mb-4">
            <div class="flex justify-between text-sm mb-2">
                <span class="text-gray-400">Progreso del curso</span>
                <span class="font-bold {{ $isComplete ? 'text-green-400' : 'text-blue-400' }}">
                    {{ $completionPercent }}%
                </span>
            </div>
            <div class="w-full bg-gray-800 rounded-full h-3">
                <div class="h-3 rounded-full transition-all duration-700
                    {{ $isComplete ? 'bg-green-500' : 'bg-blue-500' }}"
                     style="width: {{ $completionPercent }}%">
                </div>
            </div>
        </div>

        {{-- Certificate banner --}}
        @if($isComplete)
        <div class="p-5 bg-green-500/10 border border-green-500/40 
                    rounded-2xl flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <span class="text-4xl">🏆</span>
                <div>
                    <p class="text-green-400 font-bold text-lg">
                        ¡Curso completado al 100%!
                    </p>
                    <p class="text-green-300 text-sm">
                        Tu certificado está listo para descargar.
                    </p>
                </div>
            </div>
            <a href="{{ route('certificate.generate', $course) }}"
               class="flex items-center gap-2 px-6 py-3 bg-green-500 
                      hover:bg-green-400 active:scale-95 text-black 
                      font-bold rounded-xl transition-all shadow-lg 
                      shadow-green-500/30 whitespace-nowrap">
                📄 Descargar certificado
            </a>
        </div>
        @else
        <div class="p-4 bg-gray-800/50 border border-gray-700/50 
                    rounded-2xl flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <span class="text-2xl opacity-40">🏆</span>
                <div>
                    <p class="text-gray-500 font-medium text-sm">
                        Certificado disponible al completar el curso
                    </p>
                    <p class="text-gray-600 text-xs">
                        @if($totalLessonsCount > $completedCount)
                            Te faltan {{ $totalLessonsCount - $completedCount }} 
                            lecciones para obtenerlo
                        @else
                            Completa todas las lecciones para obtenerlo
                        @endif
                    </p>
                </div>
            </div>
            <span class="px-4 py-2 bg-gray-700 text-gray-500 
                         rounded-xl text-sm font-medium cursor-not-allowed">
                🔒 Bloqueado
            </span>
        </div>
        @endif

        <!-- Lessons List -->
        <section class="space-y-6">
            <h2 class="text-3xl font-bold flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">format_list_bulleted</span>
                Contenido del curso
            </h2>
            
            <div class="grid grid-cols-1 gap-4">
                @foreach($course->lessons as $lesson)
                <div class="flex items-center justify-between p-4 
                            bg-gray-800/50 hover:bg-gray-800 rounded-xl 
                            transition border border-gray-700/50">
                    
                    <div class="flex items-center gap-4">
                        {{-- Status circle --}}
                        <div class="w-8 h-8 rounded-full flex items-center 
                                    justify-center text-sm font-bold flex-shrink-0
                            {{ $completedLessons->contains($lesson->id) 
                                ? 'bg-green-500 text-white' 
                                : 'bg-gray-700 text-gray-400' }}">
                            {{ $completedLessons->contains($lesson->id) ? '✓' : $loop->iteration }}
                        </div>
                        
                        {{-- Title and type --}}
                        <div>
                            <p class="font-medium text-white text-sm">
                                {{ $lesson->title }}
                            </p>
                            <span class="text-xs text-gray-500 capitalize">
                                {{ $lesson->type }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        {{-- XP badge --}}
                        <span class="text-xs text-blue-400 font-medium">
                            +{{ $lesson->xp_reward }} XP
                        </span>
                        
                        {{-- Action button --}}
                        @if($completedLessons->contains($lesson->id))
                            <a href="{{ route('lessons.show', [$course->slug, $lesson->slug]) }}"
                               class="px-3 py-1.5 bg-green-500/20 text-green-400 
                                      rounded-lg text-xs font-medium hover:bg-green-500/30 
                                      transition">
                                ✓ Repasar
                            </a>
                        @else
                            <a href="{{ route('lessons.show', [$course->slug, $lesson->slug]) }}"
                               class="px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white 
                                      rounded-lg text-xs font-medium transition">
                                Ir →
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>
