@extends('admin.layout')
@section('breadcrumb') Logros @endsection
@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black">🏆 Logros</h1>
        <p class="text-gray-400 text-sm mt-1">
            Gestiona los logros del sistema
        </p>
    </div>
    <a href="{{ route('admin.achievements.create') }}"
       class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 
              text-white font-bold rounded-xl transition text-sm">
        + Nuevo logro
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
    @foreach($achievements as $achievement)
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
        <div class="flex items-start justify-between mb-3">
            <span class="text-4xl">{{ $achievement->icon }}</span>
            <div class="flex gap-2">
                <a href="{{ route('admin.achievements.edit', $achievement) }}"
                   class="px-3 py-1.5 bg-gray-800 hover:bg-gray-700 
                          text-gray-300 rounded-lg text-xs transition">
                    ✏️
                </a>
                <form method="POST"
                      action="{{ route('admin.achievements.destroy', $achievement) }}"
                      onsubmit="return confirm('¿Eliminar logro?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1.5 bg-red-600/20 
                                   hover:bg-red-600/40 text-red-400 
                                   rounded-lg text-xs transition">
                        🗑️
                    </button>
                </form>
            </div>
        </div>
        <h3 class="font-bold text-white mb-1">{{ $achievement->name }}</h3>
        <p class="text-gray-400 text-sm mb-3">
            {{ $achievement->description }}
        </p>
        <div class="flex items-center justify-between text-xs">
            <span class="text-gray-500">
                Condición: 
                <span class="text-blue-400">
                    {{ $achievement->condition_type }} 
                    >= {{ $achievement->condition_value }}
                </span>
            </span>
            <span class="text-green-400 font-bold">
                {{ $achievement->user_achievements_count }} ganados
            </span>
        </div>
    </div>
    @endforeach
</div>

@endsection
