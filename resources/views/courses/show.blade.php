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

        <!-- Lessons List -->
        <section class="space-y-6">
            <h2 class="text-3xl font-bold flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">format_list_bulleted</span>
                Contenido del curso
            </h2>
            
            <div class="grid grid-cols-1 gap-4">
                @foreach($course->lessons as $lesson)
                <a href="{{ route('lessons.show', [$course->slug, $lesson->slug]) }}" class="group flex items-center gap-6 bg-surface-container border border-outline-variant p-6 rounded-2xl hover:border-primary/50 transition-all">
                    <div class="w-12 h-12 rounded-full {{ $completedLessons->contains($lesson->id) ? 'bg-secondary text-on-secondary' : 'bg-surface-container-high text-slate-500' }} flex items-center justify-center font-bold text-xl transition-colors">
                        @if($completedLessons->contains($lesson->id))
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        @else
                            {{ $loop->iteration }}
                        @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="text-xl font-bold text-on-surface group-hover:text-primary transition-colors">{{ $lesson->title }}</h4>
                        <p class="text-sm text-on-surface-variant line-clamp-1">{{ $lesson->content }}</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ $lesson->type === 'reading' ? 'Lectura' : 'Ejercicio' }}</span>
                        <span class="material-symbols-outlined text-slate-500 group-hover:translate-x-1 transition-transform">chevron_right</span>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>
