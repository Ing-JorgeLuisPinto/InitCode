<x-admin-layout>
<div class="max-w-2xl mx-auto px-6 py-8">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.index', ['tab' => 'achievements']) }}" class="text-gray-400 hover:text-white transition text-sm">
            ← Volver a Logros
        </a>
    </div>
    <h1 class="text-2xl font-black text-white mb-6">🏆 Nuevo Logro</h1>

    @if(isset($errors) && $errors->any())
    <div class="mb-4 p-4 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">
        @foreach($errors->all() as $error)<p>❌ {{ $error }}</p>@endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('admin.achievements.store') }}"
          class="bg-gray-900 border border-gray-800 rounded-2xl p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Nombre</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Descripción</label>
            <textarea name="description" rows="2" required
                      class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 resize-none">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Icono (emoji)</label>
            <input type="text" name="icon" value="{{ old('icon', '⭐') }}" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Tipo de condición</label>
            <select name="condition_type" required
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                <option value="exercises_completed">Ejercicios completados</option>
                <option value="streak_days">Días de racha</option>
                <option value="first_try_correct">Correcto al primer intento</option>
                <option value="courses_started">Cursos iniciados</option>
                <option value="lessons_completed">Lecciones completadas</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Valor requerido</label>
            <input type="number" name="condition_value" value="{{ old('condition_value', 1) }}" min="1" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
            <p class="text-xs text-gray-500 mt-1">Ej: si el tipo es "días de racha" y el valor es 7, se desbloquea al llegar a 7 días seguidos.</p>
        </div>

        <button type="submit"
                class="w-full py-3 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl transition">
            Crear Logro →
        </button>
    </form>
</div>
</x-admin-layout>
