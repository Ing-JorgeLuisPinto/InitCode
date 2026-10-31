<x-admin-layout>
<div class="max-w-4xl mx-auto px-6 py-8">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.index', ['tab' => 'courses']) }}"
           class="text-gray-400 hover:text-white transition text-sm">
            ← Volver a Cursos
        </a>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-black text-white">✏️ Editar Lección</h1>
        <p class="text-gray-400 text-sm mt-1">Curso: <span class="text-blue-400 font-bold">{{ $course->title ?? $lesson->course->title }}</span></p>
    </div>

    @if(isset($errors) && $errors->any())
    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">
        @foreach($errors->all() as $error)
            <p>❌ {{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('admin.lessons.update', $lesson) }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Lesson Details Card --}}
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 space-y-5">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                📖 Información de la Lección
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Título de la Lección</label>
                    <input type="text" name="title" value="{{ old('title', $lesson->title) }}" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Orden</label>
                    <input type="number" name="order" value="{{ old('order', $lesson->order) }}" min="1" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Tipo de Lección</label>
                    <select name="type" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                        <option value="reading" {{ old('type', $lesson->type) === 'reading' ? 'selected' : '' }}>📖 Lectura</option>
                        <option value="exercise" {{ old('type', $lesson->type) === 'exercise' ? 'selected' : '' }}>💻 Ejercicio Práctico</option>
                        <option value="challenge" {{ old('type', $lesson->type) === 'challenge' ? 'selected' : '' }}>⚡ Desafío</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">XP de Recompensa (Lección)</label>
                    <input type="number" name="xp_reward" value="{{ old('xp_reward', $lesson->xp_reward) }}" min="1" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Contenido Teórico (HTML permitido)</label>
                <textarea name="content" rows="8" required
                          class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white font-mono text-sm focus:outline-none focus:border-blue-500 resize-y">{{ old('content', $lesson->content) }}</textarea>
            </div>
        </div>

        {{-- Exercise Details Card --}}
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 space-y-5">
            <div>
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    💻 Ejercicio Práctico Asociado
                </h2>
                <p class="text-xs text-gray-400 mt-1">Completa estos campos si la lección incluye un ejercicio interactivo de código.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Instrucciones del Ejercicio</label>
                <textarea name="instructions" rows="3"
                          placeholder="Instrucciones claras sobre qué debe resolver el estudiante..."
                          class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 resize-y">{{ old('instructions', $exercise?->instructions) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Código Inicial (Starter Code)</label>
                    <textarea name="starter_code" rows="6"
                              placeholder="// Código base inicial..."
                              class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white font-mono text-xs focus:outline-none focus:border-blue-500 resize-y">{{ old('starter_code', $exercise?->starter_code) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Código Solución</label>
                    <textarea name="solution_code" rows="6"
                              placeholder="// Código solución esperado..."
                              class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white font-mono text-xs focus:outline-none focus:border-blue-500 resize-y">{{ old('solution_code', $exercise?->solution_code) }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Resultado Esperado (Output)</label>
                    <textarea name="expected_output" rows="3"
                              placeholder="Salida esperada en consola..."
                              class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white font-mono text-xs focus:outline-none focus:border-blue-500 resize-y">{{ old('expected_output', $exercise?->expected_output) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">XP del Ejercicio</label>
                    <input type="number" name="exercise_xp" value="{{ old('exercise_xp', $exercise?->xp_reward) }}" min="0"
                           placeholder="Dejar vacío para usar los XP de la lección"
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                </div>
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                    class="flex-1 py-3.5 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl transition shadow-lg shadow-blue-600/20 text-center">
                Guardar Cambios →
            </button>
            <a href="{{ route('admin.index', ['tab' => 'courses']) }}"
               class="px-6 py-3.5 bg-gray-800 hover:bg-gray-700 text-gray-300 font-bold rounded-xl transition text-center">
                Cancelar
            </a>
        </div>
    </form>
</div>
</x-admin-layout>
