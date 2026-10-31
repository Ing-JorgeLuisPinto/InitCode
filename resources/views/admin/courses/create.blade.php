<x-admin-layout>
<div class="max-w-2xl mx-auto px-6 py-8">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.index', ['tab' => 'courses']) }}"
           class="text-gray-400 hover:text-white transition text-sm">
            ← Volver a Cursos
        </a>
    </div>
    <h1 class="text-2xl font-black text-white mb-6">➕ Nuevo Curso</h1>

    @if(isset($errors) && $errors->any())
    <div class="mb-4 p-4 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">
        @foreach($errors->all() as $error)
            <p>❌ {{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('admin.courses.store') }}"
          class="bg-gray-900 border border-gray-800 rounded-2xl p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Título</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Descripción</label>
            <textarea name="description" rows="3" required
                      class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 resize-none">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Icono (emoji)</label>
                <input type="text" name="icon" value="{{ old('icon', '📚') }}" required
                       class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Orden</label>
                <input type="number" name="order" value="{{ old('order', 1) }}" min="1" required
                       class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Nivel</label>
            <select name="level_id" required
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                @foreach($levels as $level)
                    <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                        {{ $level->icon }} {{ $level->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" name="is_premium" id="is_premium" value="1"
                   class="w-4 h-4 rounded" {{ old('is_premium') ? 'checked' : '' }}>
            <label for="is_premium" class="text-sm text-gray-300">Curso Premium</label>
        </div>

        <button type="submit"
                class="w-full py-3 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl transition">
            Crear Curso →
        </button>
    </form>
</div>
</x-admin-layout>
