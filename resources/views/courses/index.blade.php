<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-10">
        <header class="space-y-2">
            <h1 class="text-4xl font-black text-on-surface">Explora nuestros cursos</h1>
            <p class="text-on-surface-variant text-lg">Domina los fundamentos de la programación paso a paso.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($courses as $course)
            <div class="group relative bg-surface-container border border-outline-variant rounded-2xl overflow-hidden hover:border-primary/50 transition-all flex flex-col">
                <div class="aspect-video relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1516116216624-53e697fedbea?auto=format&fit=crop&q=80&w=1000" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-surface-container to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="bg-primary-container text-on-primary-container px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest">
                            {{ $course->level->name }}
                        </span>
                    </div>
                </div>
                
                <div class="p-6 flex-1 flex flex-col gap-4">
                    <h3 class="text-2xl font-bold text-on-surface">{{ $course->title }}</h3>
                    <p class="text-on-surface-variant text-sm line-clamp-2">{{ $course->description }}</p>
                    
                    <div class="mt-auto pt-4 space-y-3">
                        <div class="flex justify-between text-xs font-bold uppercase tracking-widest text-slate-400">
                            <span>Progreso</span>
                            <span>{{ round($course->progress_percent) }}%</span>
                        </div>
                        <div class="w-full h-2 bg-surface-container-lowest rounded-full overflow-hidden">
                            <div class="h-full bg-secondary rounded-full transition-all duration-1000" style="width: {{ $course->progress_percent }}%"></div>
                        </div>
                        <div class="flex items-center justify-between pt-2">
                            <span class="text-xs text-slate-500 font-bold uppercase tracking-widest">{{ $course->lessons->count() }} lecciones</span>
                            <a href="{{ route('courses.show', $course->slug) }}" class="inline-flex items-center gap-2 text-primary font-bold hover:underline">
                                Ver curso <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
