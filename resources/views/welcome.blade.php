<x-guest-layout>
    <div class="relative min-h-screen bg-surface-container-lowest overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute inset-0 z-0">
            <img class="w-full h-full object-cover opacity-20 mix-blend-luminosity" src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=2070" alt="Futuristic coding">
            <div class="absolute inset-0 bg-gradient-to-br from-surface-container-lowest via-surface-container-lowest/90 to-primary-container/10"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col items-center justify-center min-h-screen p-8 text-center space-y-12">
            <header class="space-y-4">
                <div class="flex flex-col items-center gap-2">
                    <span class="text-primary font-display text-8xl tracking-tighter bg-gradient-to-r from-primary to-indigo-400 bg-clip-text text-transparent font-black animate-pulse-subtle">
                        InitCode
                    </span>
                    <div class="w-32 h-1 bg-primary rounded-full shadow-[0_0_20px_rgba(80,143,248,0.5)]"></div>
                </div>
                <h2 class="text-3xl font-bold text-on-surface-variant max-w-md mx-auto">
                    La forma más divertida de aprender a programar.
                </h2>
            </header>

            <div class="space-y-6 max-w-2xl mx-auto">
                <h1 class="text-6xl font-black text-on-surface leading-tight">
                    Domina el código con <span class="text-secondary">gamificación</span> e <span class="text-primary">IA</span>.
                </h1>
                <p class="text-xl text-on-surface-variant">
                    Lecciones cortas, desafíos interactivos y un tutor personal disponible 24/7. De cero a programador en tiempo récord.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-6">
                @auth
                    <a href="{{ route('dashboard') }}" class="group px-12 py-5 bg-primary-container text-on-primary-container font-black text-xl rounded-2xl shadow-[0_0_40px_rgba(80,143,248,0.4)] hover:shadow-[0_0_60px_rgba(80,143,248,0.6)] transition-all flex items-center justify-center gap-3 active:scale-95">
                        Ir al Dashboard
                        <span class="material-symbols-outlined">dashboard</span>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="group px-12 py-5 bg-primary-container text-on-primary-container font-black text-xl rounded-2xl shadow-[0_0_40px_rgba(80,143,248,0.4)] hover:shadow-[0_0_60px_rgba(80,143,248,0.6)] transition-all flex items-center justify-center gap-3 active:scale-95">
                        Empezar Gratis
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                    <a href="{{ route('login') }}" class="px-12 py-5 bg-surface-container border border-outline-variant text-on-surface font-bold text-xl rounded-2xl hover:bg-surface-container-high transition-all active:scale-95">
                        Ya tengo cuenta
                    </a>
                @endauth
            </div>

            <!-- Features -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto pt-12">
                <div class="p-8 rounded-3xl bg-surface-container/30 border border-outline-variant backdrop-blur-sm space-y-4">
                    <span class="material-symbols-outlined text-4xl text-primary">rocket_launch</span>
                    <h3 class="text-xl font-bold">Ruta Personalizada</h3>
                    <p class="text-sm text-slate-400">Adaptamos el contenido a tu nivel y ritmo de aprendizaje.</p>
                </div>
                <div class="p-8 rounded-3xl bg-surface-container/30 border border-outline-variant backdrop-blur-sm space-y-4">
                    <span class="material-symbols-outlined text-4xl text-secondary">videogame_asset</span>
                    <h3 class="text-xl font-bold">Gamificación Total</h3>
                    <p class="text-sm text-slate-400">Gana XP, sube de nivel y desbloquea logros mientras aprendes.</p>
                </div>
                <div class="p-8 rounded-3xl bg-surface-container/30 border border-outline-variant backdrop-blur-sm space-y-4">
                    <span class="material-symbols-outlined text-4xl text-tertiary">smart_toy</span>
                    <h3 class="text-xl font-bold">Tutor IA 24/7</h3>
                    <p class="text-sm text-slate-400">Resuelve tus dudas al instante con nuestro tutor inteligente.</p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
