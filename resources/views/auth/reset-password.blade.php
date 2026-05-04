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
                Crea una nueva contraseña
            </p>
        </div>

        <div class="bg-gray-900 border border-gray-800 
                    rounded-2xl p-8">

            <h2 class="text-xl font-bold text-white mb-6">
                🔑 Nueva contraseña
            </h2>

            <form method="POST" 
                  action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" 
                       value="{{ $request->route('token') }}">

                <div class="mb-4">
                    <label class="block text-sm font-medium 
                                  text-gray-400 mb-2">
                        Correo electrónico
                    </label>
                    <input type="email"
                           name="email"
                           value="{{ old('email', $request->email) }}"
                           required
                           class="w-full bg-gray-800 border border-gray-700 
                                  rounded-xl px-4 py-3 text-white 
                                  placeholder-gray-500 focus:outline-none 
                                  focus:border-blue-500 transition text-sm">
                    @error('email')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium 
                                  text-gray-400 mb-2">
                        Nueva contraseña
                    </label>
                    <input type="password"
                           name="password"
                           required
                           placeholder="Mínimo 8 caracteres"
                           class="w-full bg-gray-800 border border-gray-700 
                                  rounded-xl px-4 py-3 text-white 
                                  placeholder-gray-500 focus:outline-none 
                                  focus:border-blue-500 transition text-sm">
                    @error('password')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium 
                                  text-gray-400 mb-2">
                        Confirmar contraseña
                    </label>
                    <input type="password"
                           name="password_confirmation"
                           required
                           placeholder="Repite tu nueva contraseña"
                           class="w-full bg-gray-800 border border-gray-700 
                                  rounded-xl px-4 py-3 text-white 
                                  placeholder-gray-500 focus:outline-none 
                                  focus:border-blue-500 transition text-sm">
                </div>

                <button type="submit"
                        class="w-full py-3 bg-blue-600 hover:bg-blue-500 
                               text-white font-bold rounded-xl transition">
                    Restablecer contraseña →
                </button>
            </form>
        </div>
    </div>
</div>
</x-guest-layout>
