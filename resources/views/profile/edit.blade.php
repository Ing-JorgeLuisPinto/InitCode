<x-app-layout>
<div class="max-w-3xl mx-auto px-6 py-8">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('profile.show') }}"
           class="text-gray-400 hover:text-white transition text-sm flex items-center gap-2">
            ← Volver al perfil
        </a>
    </div>

    <h1 class="text-3xl font-black text-white mb-2">✏️ Editar perfil</h1>
    <p class="text-gray-400 mb-8">Actualiza tu información personal</p>

    {{-- Success message --}}
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 
                rounded-xl text-green-400 text-sm font-medium">
        {{ session('success') }}
    </div>
    @endif

    {{-- SECTION 1: Personal info --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 mb-6">
        <h2 class="text-lg font-bold text-white mb-6">👤 Información personal</h2>

        <form method="POST" 
              action="{{ route('profile.update') }}"
              enctype="multipart/form-data"
              class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Avatar --}}
            <div class="flex items-center gap-6">
                
                {{-- Preview circle --}}
                <div class="relative flex-shrink-0">
                    <div id="avatar-preview-container">
                        @if($user->avatar)
                            <img id="avatar-preview"
                                 src="{{ asset('storage/' . $user->avatar) }}"
                                 alt="Avatar"
                                 class="w-24 h-24 rounded-full object-cover 
                                        border-2 border-blue-500 shadow-lg 
                                        shadow-blue-500/20">
                        @else
                            <div id="avatar-initials"
                                 class="w-24 h-24 rounded-full bg-gradient-to-br 
                                        from-blue-600 to-green-400 flex items-center 
                                        justify-center text-white text-3xl font-black">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <img id="avatar-preview"
                                 src=""
                                 alt="Preview"
                                 class="w-24 h-24 rounded-full object-cover 
                                        border-2 border-blue-500 shadow-lg 
                                        shadow-blue-500/20 hidden">
                        @endif
                    </div>
                    
                    {{-- Camera icon overlay --}}
                    <label for="avatar-input"
                           class="absolute bottom-0 right-0 w-7 h-7 bg-blue-600 
                                  hover:bg-blue-500 rounded-full flex items-center 
                                  justify-center cursor-pointer transition
                                  shadow-lg border-2 border-gray-900">
                        <span class="text-xs">📷</span>
                    </label>
                </div>

                {{-- File input and info --}}
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Foto de perfil
                    </label>
                    
                    <input type="file"
                           id="avatar-input"
                           name="avatar"
                           accept="image/jpeg,image/png,image/webp"
                           class="hidden">
                    
                    <button type="button"
                            onclick="document.getElementById('avatar-input').click()"
                            class="px-4 py-2 bg-gray-800 hover:bg-gray-700 
                                   text-gray-300 hover:text-white border border-gray-700 
                                   hover:border-gray-500 rounded-xl text-sm 
                                   font-medium transition cursor-pointer">
                        📁 Seleccionar imagen
                    </button>

                    <p id="avatar-filename" 
                       class="text-xs text-gray-500 mt-2">
                        Ningún archivo seleccionado
                    </p>
                    <p class="text-xs text-gray-600 mt-1">
                        JPG, PNG o WEBP · Máximo 2MB
                    </p>

                    @error('avatar')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    {{-- Preview badge --}}
                    <div id="preview-badge" 
                         class="hidden mt-2 inline-flex items-center gap-1 px-3 py-1 
                                bg-green-500/20 text-green-400 border border-green-500/30 
                                rounded-full text-xs font-medium">
                        ✅ Vista previa lista — guarda los cambios para confirmar
                    </div>
                </div>
            </div>

            {{-- Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">
                    Nombre completo
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       required
                       class="w-full bg-gray-800 border border-gray-700 rounded-xl
                              px-4 py-3 text-white focus:outline-none
                              focus:border-blue-500 transition
                              @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email (readonly) --}}
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">
                    Correo electrónico
                    <span class="text-gray-600 font-normal">(no se puede cambiar)</span>
                </label>
                <input type="email"
                       value="{{ $user->email }}"
                       disabled
                       class="w-full bg-gray-800/50 border border-gray-700/50 
                              rounded-xl px-4 py-3 text-gray-500 cursor-not-allowed">
            </div>

            {{-- Bio --}}
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">
                    Bio
                    <span class="text-gray-600 font-normal">(opcional)</span>
                </label>
                <textarea name="bio"
                          rows="3"
                          maxlength="300"
                          placeholder="Cuéntanos algo sobre ti..."
                          class="w-full bg-gray-800 border border-gray-700 rounded-xl
                                 px-4 py-3 text-white focus:outline-none
                                 focus:border-blue-500 transition resize-none">{{ old('bio', $user->bio) }}</textarea>
                <p class="text-xs text-gray-600 mt-1">Máximo 300 caracteres</p>
            </div>

            <button type="submit"
                    class="w-full py-3 bg-blue-600 hover:bg-blue-500 text-white
                           font-bold rounded-xl transition">
                Guardar cambios →
            </button>
        </form>
    </div>

    {{-- SECTION 2: Change password --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
        <h2 class="text-lg font-bold text-white mb-6">🔒 Cambiar contraseña</h2>

        <form method="POST"
              action="{{ route('profile.password') }}"
              class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">
                    Contraseña actual
                </label>
                <input type="password"
                       name="current_password"
                       required
                       placeholder="Tu contraseña actual"
                       class="w-full bg-gray-800 border border-gray-700 rounded-xl
                              px-4 py-3 text-white focus:outline-none
                              focus:border-blue-500 transition
                              @error('current_password') border-red-500 @enderror">
                @error('current_password')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">
                    Nueva contraseña
                </label>
                <input type="password"
                       name="password"
                       required
                       placeholder="Mínimo 8 caracteres"
                       class="w-full bg-gray-800 border border-gray-700 rounded-xl
                              px-4 py-3 text-white focus:outline-none
                              focus:border-blue-500 transition
                              @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">
                    Confirmar nueva contraseña
                </label>
                <input type="password"
                       name="password_confirmation"
                       required
                       placeholder="Repite la nueva contraseña"
                       class="w-full bg-gray-800 border border-gray-700 rounded-xl
                              px-4 py-3 text-white focus:outline-none
                              focus:border-blue-500 transition">
            </div>

            <button type="submit"
                    class="w-full py-3 bg-gray-700 hover:bg-gray-600 text-white
                           font-bold rounded-xl transition">
                Cambiar contraseña →
            </button>
        </form>
    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('avatar-input');
    const preview = document.getElementById('avatar-preview');
    const initials = document.getElementById('avatar-initials');
    const filename = document.getElementById('avatar-filename');
    const badge = document.getElementById('preview-badge');

    if (!input) return;

    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Validate size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            filename.textContent = '❌ La imagen supera 2MB';
            filename.classList.add('text-red-400');
            filename.classList.remove('text-gray-500');
            input.value = '';
            return;
        }

        // Show filename
        filename.textContent = file.name;
        filename.classList.remove('text-red-400');
        filename.classList.add('text-gray-400');

        // Show preview
        const reader = new FileReader();
        reader.onload = function(event) {
            if (preview) {
                preview.src = event.target.result;
                preview.classList.remove('hidden');
            }
            // Hide initials if showing
            if (initials) {
                initials.classList.add('hidden');
            }
            // Show badge
            if (badge) {
                badge.classList.remove('hidden');
            }
        };
        reader.readAsDataURL(file);
    });
});
</script>
</x-app-layout>
