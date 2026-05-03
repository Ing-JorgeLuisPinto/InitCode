@extends('admin.layout')
@section('breadcrumb')
    <a href="{{ route('admin.achievements') }}" 
       class="hover:text-white">Logros</a> / Editar logro
@endsection
@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.achievements') }}"
       class="text-gray-400 hover:text-white text-sm mb-6 inline-block">
        ← Volver
    </a>
    <h1 class="text-2xl font-black mb-8">✏️ Editar logro</h1>

    <form method="POST" action="{{ route('admin.achievements.update', $achievement) }}"
          class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">
                    Nombre
                </label>
                <input type="text" name="name" required
                       value="{{ old('name', $achievement->name) }}"
                       class="w-full bg-gray-800 border border-gray-700 
                              rounded-xl px-4 py-3 text-white 
                              focus:outline-none focus:border-blue-500 
                              transition text-sm"
                       placeholder="Primera línea">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">
                    Icono (emoji)
                </label>
                <input type="text" name="icon" required maxlength="5"
                       value="{{ old('icon', $achievement->icon) }}"
                       class="w-full bg-gray-800 border border-gray-700 
                              rounded-xl px-4 py-3 text-white 
                              focus:outline-none focus:border-blue-500 
                              transition text-sm"
                       placeholder="⭐">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">
                Descripción
            </label>
            <textarea name="description" required rows="2"
                      class="w-full bg-gray-800 border border-gray-700 
                             rounded-xl px-4 py-3 text-white 
                             focus:outline-none focus:border-blue-500 
                             transition text-sm resize-none"
                      placeholder="Completa tu primer ejercicio">{{ old('description', $achievement->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">
                    Tipo de condición
                </label>
                <select name="condition_type" required
                        class="w-full bg-gray-800 border border-gray-700 
                               rounded-xl px-4 py-3 text-white 
                               focus:outline-none focus:border-blue-500 
                               transition text-sm">
                    <option value="exercises_completed" {{ old('condition_type', $achievement->condition_type) === 'exercises_completed' ? 'selected' : '' }}>exercises_completed</option>
                    <option value="streak_days" {{ old('condition_type', $achievement->condition_type) === 'streak_days' ? 'selected' : '' }}>streak_days</option>
                    <option value="first_try_correct" {{ old('condition_type', $achievement->condition_type) === 'first_try_correct' ? 'selected' : '' }}>first_try_correct</option>
                    <option value="courses_started" {{ old('condition_type', $achievement->condition_type) === 'courses_started' ? 'selected' : '' }}>courses_started</option>
                    <option value="xp_total" {{ old('condition_type', $achievement->condition_type) === 'xp_total' ? 'selected' : '' }}>xp_total</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">
                    Valor requerido
                </label>
                <input type="number" name="condition_value" required min="1"
                       value="{{ old('condition_value', $achievement->condition_value) }}"
                       class="w-full bg-gray-800 border border-gray-700 
                              rounded-xl px-4 py-3 text-white 
                              focus:outline-none focus:border-blue-500 
                              transition text-sm">
            </div>
        </div>

        <button type="submit"
                class="w-full py-3 bg-blue-600 hover:bg-blue-500 
                       text-white font-bold rounded-xl transition">
            Actualizar logro →
        </button>
    </form>
</div>

@endsection
