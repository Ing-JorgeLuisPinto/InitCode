<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center p-6 bg-surface-container-lowest">
        <div class="w-full max-w-md bg-surface-container border border-outline-variant p-8 rounded-2xl shadow-xl text-center">
            <div class="text-center mb-8">
                <div class="text-6xl mb-4 text-center mx-auto">📧</div>
                <h1 class="text-2xl font-black text-white mb-2">
                    Verifica tu correo
                </h1>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Enviamos un enlace de verificación a 
                    <strong class="text-white">{{ auth()->user()->email }}</strong>.
                    Ábrelo y haz clic en el enlace para activar tu cuenta.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 
                        rounded-xl text-green-400 text-sm text-center">
                ✅ Se envió un nuevo enlace. Revisa tu bandeja de entrada.
            </div>
            @endif

            <div class="p-4 bg-blue-500/10 border border-blue-500/20 
                        rounded-xl text-sm mb-6 text-left">
                <p class="font-medium text-blue-400 mb-2">💡 ¿No encuentras el correo?</p>
                <ul class="text-gray-400 space-y-1 text-xs">
                    <li>• Revisa tu carpeta de <strong>spam o correo no deseado</strong></li>
                    <li>• El asunto es: <strong>"Verifica tu dirección de email"</strong></li>
                    <li>• Puede tardar hasta 2 minutos en llegar</li>
                </ul>
            </div>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                        class="w-full py-3 bg-primary text-on-primary font-bold rounded-xl transition mb-4 hover:opacity-90">
                    📨 Reenviar correo de verificación
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full py-3 border border-outline-variant hover:border-outline 
                               text-on-surface-variant hover:text-on-surface font-medium 
                               rounded-xl transition text-sm">
                    Volver al inicio de sesión
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
