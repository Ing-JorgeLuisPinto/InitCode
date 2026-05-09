<x-guest-layout>
    <main class="min-h-screen flex flex-col md:flex-row">
        <!-- Left half: Decorative Panel -->
        <section class="relative hidden md:flex md:w-1/2 lg:w-3/5 bg-surface-container-lowest overflow-hidden items-center justify-center border-r border-outline-variant">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 z-0">
                <img class="w-full h-full object-cover opacity-30 mix-blend-luminosity" src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=2070" alt="Futuristic coding">
                <div class="absolute inset-0 bg-gradient-to-br from-surface-container-lowest via-surface-container-lowest/80 to-primary-container/20"></div>
            </div>
            <!-- Content Overlay -->
            <div class="relative z-10 p-16 flex flex-col items-start gap-8 max-w-2xl">
                <div class="flex flex-col gap-2">
                    <span class="text-primary font-display text-4xl tracking-tighter bg-gradient-to-r from-primary to-indigo-400 bg-clip-text text-transparent font-black">
                        InitCode
                    </span>
                    <p class="text-xl text-on-surface-variant max-w-md">
                        Aprende a programar
                    </p>
                </div>
                <div class="space-y-4">
                    <h1 class="text-6xl font-bold text-on-surface">
                        Bienvenido de nuevo
                    </h1>
                    <p class="text-lg text-on-surface-variant leading-relaxed">
                        Continúa tu camino hacia la maestría. Tus desafíos y recompensas te están esperando.
                    </p>
                </div>
            </div>
        </section>

        <!-- Right side: Form -->
        <section class="flex-1 flex items-center justify-center p-8 md:p-16 lg:p-24 bg-surface-container-lowest">
            <div class="w-full max-w-md flex flex-col gap-10">
                <div class="md:hidden flex flex-col items-center gap-2 mb-4">
                    <span class="text-primary text-4xl tracking-tighter font-black">InitCode</span>
                    <div class="w-12 h-1 bg-primary rounded-full"></div>
                </div>
                <header class="space-y-2 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-on-surface">Inicia Sesión</h2>
                    <p class="text-on-surface-variant">Accede a tu plataforma de aprendizaje.</p>
                </header>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                @if ($errors->any())
                <div class="mb-4 p-4 bg-red-500/10 border border-red-500/30 
                            rounded-xl text-red-400 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>❌ {{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6">
                    @csrf
                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant px-1" for="email">Correo electrónico</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline group-focus-within:text-primary transition-colors">mail</span>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="nombre@ejemplo.com" class="w-full bg-surface-container border border-outline-variant rounded-lg py-3.5 pl-12 pr-4 text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant px-1" for="password">Contraseña</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline group-focus-within:text-primary transition-colors">lock</span>
                            <input id="password" name="password" type="password" required placeholder="••••••••" class="w-full bg-surface-container border border-outline-variant rounded-lg py-3.5 pl-12 pr-4 text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded bg-surface-container border-outline-variant text-primary shadow-sm focus:ring-primary" name="remember">
                            <span class="ms-2 text-sm text-on-surface-variant">Recordarme</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-sm text-primary hover:underline" href="{{ route('password.request') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="group mt-4 w-full bg-primary-container text-on-primary-container font-bold py-4 rounded-xl shadow-[0_0_30px_rgba(80,143,248,0.3)] hover:shadow-[0_0_40px_rgba(80,143,248,0.5)] transition-all flex items-center justify-center gap-3 active:scale-95">
                        Entrar
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">login</span>
                    </button>
                </form>

                <footer class="flex flex-col gap-8">
                    <p class="text-center text-on-surface-variant">
                        ¿No tienes cuenta? 
                        <a class="text-primary font-bold hover:underline underline-offset-4 ml-1" href="{{ route('register') }}">Regístrate gratis</a>
                    </p>
                </footer>
            </div>
        </section>
    </main>
</x-guest-layout>
