<x-admin-layout>
<div class="max-w-2xl mx-auto px-6 py-8">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.index', ['tab' => 'achievements']) }}" class="text-gray-400 hover:text-white transition text-sm">
            ← Volver a Logros
        </a>
    </div>
    <h1 class="text-2xl font-black text-white mb-6">✏️ Editar Logro</h1>

    <form method="POST" action="{{ route('admin.achievements.update', $achievement) }}"
          class="bg-gray-900 border border-gray-800 rounded-2xl p-6 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $achievement->name) }}" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Descripción</label>
            <textarea name="description" rows="2" required
                      class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 resize-none">{{ old('description', $achievement->description) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Icono (emoji)</label>
            <input type="text" name="icon" value="{{ old('icon', $achievement->icon) }}" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Tipo de condición</label>
            <select name="condition_type" required
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                @foreach(['exercises_completed' => 'Ejercicios completados', 'streak_days' => 'Días de racha', 'first_try_correct' => 'Correcto al primer intento', 'courses_started' => 'Cursos iniciados', 'lessons_completed' => 'Lecciones completadas'] as $val => $label)
                    <option value="{{ $val }}" {{ $achievement->condition_type === $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Valor requerido</label>
            <input type="number" name="condition_value" value="{{ old('condition_value', $achievement->condition_value) }}" min="1" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
        </div>
        <button type="submit"
                class="w-full py-3 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl transition">
            Guardar Cambios →
        </button>
    </form>
</div>
</x-admin-layout>
