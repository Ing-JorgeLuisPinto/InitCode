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
                        Empieza tu aventura
                    </h1>
                    <p class="text-lg text-on-surface-variant leading-relaxed">
                        Únete a miles de desarrolladores que están transformando su futuro. Domina las tecnologías más demandadas con nuestra IA personalizada.
                    </p>
                </div>
                <div class="flex gap-4 mt-8">
                    <div class="w-12 h-1 bg-primary rounded-full shadow-[0_0_15px_rgba(80,143,248,0.5)]"></div>
                    <div class="w-8 h-1 bg-outline-variant rounded-full"></div>
                    <div class="w-8 h-1 bg-outline-variant rounded-full"></div>
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
                    <h2 class="text-3xl font-bold text-on-surface">Crea tu cuenta gratis</h2>
                    <p class="text-on-surface-variant">Tu camino al éxito comienza con un solo paso.</p>
                </header>

                <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-6">
                    @csrf
                    <!-- Name -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant px-1" for="name">Nombre completo</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline group-focus-within:text-primary transition-colors">person</span>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus placeholder="John Doe" class="w-full bg-surface-container border border-outline-variant rounded-lg py-3.5 pl-12 pr-4 text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant px-1" for="email">Correo electrónico</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline group-focus-within:text-primary transition-colors">mail</span>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required placeholder="nombre@ejemplo.com" class="w-full bg-surface-container border border-outline-variant rounded-lg py-3.5 pl-12 pr-4 text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            Ejemplo: usuario@correo.com
                        </p>
                        @error('email')
                            <p class="text-red-400 text-xs mt-1">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant px-1" for="password">Contraseña</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline group-focus-within:text-primary transition-colors">lock</span>
                            <input id="password" name="password" type="password" required placeholder="••••••••" class="w-full bg-surface-container border border-outline-variant rounded-lg py-3.5 pl-12 pr-4 text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                        </div>
                        
                        <div class="mt-1 p-3 bg-gray-800/50 border border-gray-700 rounded-xl text-xs text-gray-400 space-y-1">
                            <p class="font-medium text-gray-300 mb-2">La contraseña debe tener:</p>
                            <p id="req-length"  class="flex items-center gap-2">
                                <span class="req-icon">⚪</span> Mínimo 8 caracteres
                            </p>
                            <p id="req-upper"   class="flex items-center gap-2">
                                <span class="req-icon">⚪</span> Al menos una mayúscula (A-Z)
                            </p>
                            <p id="req-lower"   class="flex items-center gap-2">
                                <span class="req-icon">⚪</span> Al menos una minúscula (a-z)
                            </p>
                            <p id="req-number"  class="flex items-center gap-2">
                                <span class="req-icon">⚪</span> Al menos un número (0-9)
                            </p>
                            <p id="req-symbol"  class="flex items-center gap-2">
                                <span class="req-icon">⚪</span> Al menos un símbolo (!@#$%...)
                            </p>
                        </div>

                        <div class="mt-2">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>Seguridad de la contraseña</span>
                                <span id="strength-label">—</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div id="strength-bar" 
                                     class="h-2 rounded-full transition-all duration-300"
                                     style="width: 0%"></div>
                            </div>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant px-1" for="password_confirmation">Confirmar contraseña</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline group-focus-within:text-primary transition-colors">verified_user</span>
                            <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="••••••••" class="w-full bg-surface-container border border-outline-variant rounded-lg py-3.5 pl-12 pr-4 text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <button type="submit" class="group mt-4 w-full bg-primary-container text-on-primary-container font-bold py-4 rounded-xl shadow-[0_0_30px_rgba(80,143,248,0.3)] hover:shadow-[0_0_40px_rgba(80,143,248,0.5)] transition-all flex items-center justify-center gap-3 active:scale-95">
                        Crear cuenta
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </button>
                </form>

                <footer class="flex flex-col gap-8">
                    <p class="text-center text-on-surface-variant">
                        ¿Ya tienes cuenta? 
                        <a class="text-primary font-bold hover:underline underline-offset-4 ml-1" href="{{ route('login') }}">Inicia sesión</a>
                    </p>
                </footer>
            </div>
        </section>
    </main>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.querySelector('input[name="password"]');
        if (!passwordInput) return;

        const requirements = {
            length:  { el: document.getElementById('req-length'),  test: v => v.length >= 8 },
            upper:   { el: document.getElementById('req-upper'),   test: v => /[A-Z]/.test(v) },
            lower:   { el: document.getElementById('req-lower'),   test: v => /[a-z]/.test(v) },
            number:  { el: document.getElementById('req-number'),  test: v => /[0-9]/.test(v) },
            symbol:  { el: document.getElementById('req-symbol'),  test: v => /[^A-Za-z0-9]/.test(v) },
        };

        const bar   = document.getElementById('strength-bar');
        const label = document.getElementById('strength-label');

        const levels = [
            { label: 'Muy débil',  color: '#ef4444', width: '20%' },
            { label: 'Débil',      color: '#f97316', width: '40%' },
            { label: 'Regular',    color: '#eab308', width: '60%' },
            { label: 'Fuerte',     color: '#22c55e', width: '80%' },
            { label: 'Muy fuerte', color: '#3b82f6', width: '100%' },
        ];

        passwordInput.addEventListener('input', function() {
            const val   = this.value;
            let passed  = 0;

            Object.values(requirements).forEach(req => {
                const ok = req.test(val);
                if (ok) passed++;
                if (req.el) {
                    req.el.querySelector('.req-icon').textContent = ok ? '✅' : '⚪';
                    req.el.style.color = ok ? '#4ade80' : '';
                }
            });

            if (val.length === 0) {
                bar.style.width     = '0%';
                bar.style.background = '';
                label.textContent   = '—';
            } else {
                const level = levels[Math.min(passed - 1, 4)];
                bar.style.width      = level.width;
                bar.style.background = level.color;
                label.textContent    = level.label;
                label.style.color    = level.color;
            }
        });
    });
    </script>
</x-guest-layout>
