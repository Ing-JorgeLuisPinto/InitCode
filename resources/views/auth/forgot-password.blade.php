<x-guest-layout>
<div class="min-h-screen bg-gray-950 flex items-center 
            justify-center px-4">
    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-white">
                ⚡ InitCode
            </h1>
            <p class="text-gray-400 text-sm mt-1">
                Recupera el acceso a tu cuenta
            </p>
        </div>

        <div class="bg-gray-900 border border-gray-800 
                    rounded-2xl p-8">

            @if (session('status'))
            <div class="mb-6 p-4 bg-green-500/10 border 
                        border-green-500/30 rounded-xl">
                <p class="text-green-400 text-sm font-medium">
                    ✅ {{ session('status') }}
                </p>
            </div>
            @endif

            <h2 class="text-xl font-bold text-white mb-2">
                🔐 Olvidé mi contraseña
            </h2>
            <p class="text-gray-400 text-sm mb-6">
                Ingresa tu correo electrónico y te enviaremos 
                un enlace para restablecer tu contraseña.
            </p>

            <form method="POST" 
                  action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium 
                                  text-gray-400 mb-2">
                        Correo electrónico
                    </label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           placeholder="tu@correo.com"
                           class="w-full bg-gray-800 border rounded-xl 
                                  px-4 py-3 text-white placeholder-gray-500 
                                  focus:outline-none focus:border-blue-500 
                                  transition text-sm
                                  {{ $errors->has('email') 
                                      ? 'border-red-500' 
                                      : 'border-gray-700' }}">
                    @error('email')
                    <p class="text-red-400 text-xs mt-1">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-3 bg-blue-600 hover:bg-blue-500 
                               text-white font-bold rounded-xl transition">
                    Enviar enlace de recuperación →
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}"
                   class="text-sm text-gray-500 hover:text-gray-300 
                          transition">
                    ← Volver al inicio de sesión
                </a>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>
