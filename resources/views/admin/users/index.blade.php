@extends('admin.layout')
@section('breadcrumb') Usuarios @endsection
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-black">👥 Usuarios</h1>
        <p class="text-gray-400 text-sm mt-1">
            {{ $users->total() }} usuarios registrados
        </p>
    </div>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.users') }}" class="mb-6">
    <div class="flex gap-3">
        <input type="text" name="search" value="{{ $search }}"
               placeholder="Buscar por nombre o email..."
               class="flex-1 bg-gray-900 border border-gray-700 rounded-xl 
                      px-4 py-2.5 text-white placeholder-gray-500 
                      focus:outline-none focus:border-blue-500 
                      transition text-sm">
        <button type="submit"
                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 
                       text-white font-bold rounded-xl transition text-sm">
            Buscar
        </button>
        @if($search)
        <a href="{{ route('admin.users') }}"
           class="px-5 py-2.5 bg-gray-800 hover:bg-gray-700 
                  text-gray-300 rounded-xl transition text-sm">
            ✕ Limpiar
        </a>
        @endif
    </div>
</form>

<div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-800">
            <tr class="text-gray-400 text-left">
                <th class="px-6 py-4">Usuario</th>
                <th class="px-6 py-4">Nivel</th>
                <th class="px-6 py-4">XP</th>
                <th class="px-6 py-4">Racha</th>
                <th class="px-6 py-4">Estado</th>
                <th class="px-6 py-4">Registro</th>
                <th class="px-6 py-4">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
            @foreach($users as $user)
            <tr class="hover:bg-gray-800/50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br 
                                    from-blue-500 to-purple-600 flex items-center 
                                    justify-center text-xs font-black flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-white">
                                {{ $user->name }}
                                @if($user->is_admin)
                                <span class="ml-1 px-1.5 py-0.5 bg-red-500/20 
                                             text-red-400 rounded text-xs">
                                    Admin
                                </span>
                                @endif
                            </p>
                            <p class="text-gray-500 text-xs">
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-400 text-xs">
                    {{ $user->level?->icon }} {{ $user->level?->name ?? '-' }}
                </td>
                <td class="px-6 py-4 text-blue-400 font-bold">
                    {{ $user->xp }}
                </td>
                <td class="px-6 py-4 text-orange-400">
                    🔥 {{ $user->streak_days }}
                </td>
                <td class="px-6 py-4">
                    @if($user->is_premium)
                    <span class="px-2 py-1 bg-yellow-500/20 text-yellow-400 
                                 rounded-full text-xs">💎 Premium</span>
                    @else
                    <span class="px-2 py-1 bg-gray-700 text-gray-400 
                                 rounded-full text-xs">Gratis</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-gray-500 text-xs">
                    {{ $user->created_at->format('d/m/Y') }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.users.show', $user) }}"
                           class="px-3 py-1.5 bg-blue-600/20 hover:bg-blue-600/40 
                                  text-blue-400 rounded-lg text-xs transition">
                            👁️ Ver
                        </a>
                        <form method="POST"
                              action="{{ route('admin.users.toggle-premium', $user) }}">
                            @csrf @method('PUT')
                            <button type="submit"
                                    class="px-3 py-1.5 bg-yellow-500/20 
                                           hover:bg-yellow-500/40 text-yellow-400 
                                           rounded-lg text-xs transition">
                                💎
                            </button>
                        </form>
                        @if($user->id !== auth()->id())
                        <form method="POST"
                              action="{{ route('admin.users.destroy', $user) }}"
                              onsubmit="return confirm('¿Eliminar usuario?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1.5 bg-red-600/20 
                                           hover:bg-red-600/40 text-red-400 
                                           rounded-lg text-xs transition">
                                🗑️
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $users->links() }}</div>

@endsection
