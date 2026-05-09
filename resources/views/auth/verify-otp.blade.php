<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center p-6 bg-surface-container-lowest">
        <div class="w-full max-w-md bg-surface-container border border-outline-variant p-8 rounded-2xl shadow-xl text-center">
            <div class="text-center mb-8">
                <div class="text-6xl mb-4 text-center mx-auto">📬</div>
                <h1 class="text-2xl font-black text-white mb-2">
                    Revisa tu correo
                </h1>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Enviamos un código de 6 dígitos a 
                    <strong class="text-white">{{ auth()->user()->email }}</strong>.
                    Ingrésalo aquí para activar tu cuenta.
                </p>
            </div>

            @if (session('status') == 'code-sent')
            <div class="mb-4 p-3 bg-green-500/10 border border-green-500/30 
                        rounded-xl text-green-400 text-sm text-center">
                ✅ Se envió un nuevo código a tu correo.
            </div>
            @endif

            @if ($errors->any())
            <div class="mb-4 p-3 bg-red-500/10 border border-red-500/30 
                        rounded-xl text-red-400 text-sm">
                @foreach ($errors->all() as $error)
                    <p>❌ {{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('verification.otp.verify') }}">
                @csrf
                <div class="mb-6 text-left">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Código de verificación
                    </label>
                    <input 
                        type="text" 
                        name="code" 
                        maxlength="6" 
                        placeholder="000000" 
                        autofocus
                        class="w-full px-4 py-4 bg-surface-container-low border border-outline-variant 
                               rounded-xl text-white text-center text-3xl font-mono 
                               tracking-[0.5em] focus:outline-none focus:border-primary
                               transition"
                    />
                    <p class="text-xs text-gray-500 mt-2 text-center">
                        El código expira en 15 minutos
                    </p>
                </div>

                <button type="submit"
                        class="w-full py-3 bg-primary text-on-primary font-bold rounded-xl transition mb-4 hover:opacity-90">
                    ✅ Verificar cuenta
                </button>
            </form>

            <form method="POST" action="{{ route('verification.otp.send') }}">
                @csrf
                <button type="submit"
                        class="w-full py-3 border border-outline-variant hover:border-outline 
                               text-on-surface-variant hover:text-on-surface font-medium 
                               rounded-xl transition text-sm mb-3">
                    📨 Reenviar código
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full py-2 text-gray-600 hover:text-gray-400 
                               text-xs transition">
                    Volver al inicio de sesión
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
