<x-guest-layout>
    <main class="min-h-screen flex items-center justify-center p-8 bg-surface-container-lowest">
        <div class="w-full max-w-4xl space-y-12 text-center">
            <header class="space-y-4">
                <h1 class="text-5xl font-black text-on-surface">¿Cuánto sabes de programación?</h1>
                <p class="text-xl text-on-surface-variant max-w-2xl mx-auto">Queremos darte la mejor experiencia. Cuéntanos tu nivel actual para personalizar tu ruta de aprendizaje.</p>
            </header>

            <form method="POST" action="{{ route('select-level') }}" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @csrf
                @foreach($levels as $level)
                <label class="relative group cursor-pointer">
                    <input type="radio" name="level_id" value="{{ $level->id }}" class="peer absolute opacity-0" required {{ $loop->first ? 'checked' : '' }}>
                    <div class="h-full p-8 rounded-2xl bg-surface-container border-2 border-outline-variant transition-all peer-checked:border-primary peer-checked:bg-primary/10 hover:border-primary/50 flex flex-col items-center gap-6">
                        <div class="w-20 h-20 rounded-full bg-surface-container-high flex items-center justify-center text-4xl shadow-xl group-hover:scale-110 transition-transform">
                            @if($level->level_number == 1) 🌱 @elseif($level->level_number == 2) 🚀 @else 💎 @endif
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-2xl font-bold text-on-surface">{{ $level->name }}</h3>
                            <p class="text-sm text-on-surface-variant">{{ $level->description }}</p>
                        </div>
                    </div>
                </label>
                @endforeach

                <div class="md:col-span-3 pt-8">
                    <button type="submit" class="inline-flex items-center gap-3 px-12 py-4 bg-primary-container text-on-primary-container font-bold text-lg rounded-full shadow-[0_0_30px_rgba(80,143,248,0.3)] hover:shadow-[0_0_50px_rgba(80,143,248,0.5)] transition-all active:scale-95">
                        Empezar mi camino
                        <span class="material-symbols-outlined">rocket_launch</span>
                    </button>
                </div>
            </form>
        </div>
    </main>
</x-guest-layout>
