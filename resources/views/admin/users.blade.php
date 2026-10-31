@extends('admin.layout')

@section('breadcrumb')
<span class="text-gray-400">Panel</span> / <span class="text-white">Usuarios</span>
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">👥 Gestión de Usuarios</h1>
            <p class="text-gray-400 text-sm mt-1">
                {{ $users->total() }} {{ Str::plural('usuario registrado', $users->total()) }} en la plataforma
            </p>
        </div>
    </div>

    {{-- Search Bar --}}
    <form method="GET" action="{{ route('admin.users') }}" class="flex gap-3">
        <div class="relative flex-1">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                   placeholder="Buscar por nombre o correo electrónico..."
                   class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition text-sm">
        </div>
        <button type="submit"
                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl transition text-sm flex items-center gap-2 shadow-lg shadow-blue-600/15">
            🔍 Buscar
        </button>
        @if(!empty($search))
        <a href="{{ route('admin.users') }}"
           class="px-4 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 font-semibold rounded-xl transition text-sm flex items-center gap-1.5">
            ✕ Limpiar
        </a>
        @endif
    </form>

    {{-- Users Table --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-950/60 border-b border-gray-800 text-gray-400 text-xs font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Usuario</th>
                        <th class="px-6 py-4">Rol</th>
                        <th class="px-6 py-4">Nivel</th>
                        <th class="px-6 py-4">XP Total</th>
                        <th class="px-6 py-4">Racha</th>
                        <th class="px-6 py-4">Registro</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-800/30 transition">
                        {{-- User Name & Email --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-xs font-black text-white flex-shrink-0 shadow-md shadow-blue-500/20">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-white text-sm">
                                        {{ $user->name }}
                                    </p>
                                    <p class="text-gray-500 text-xs">
                                        {{ $user->email }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        {{-- Role --}}
                        <td class="px-6 py-4">
                            @if($user->is_admin)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-500/10 text-red-400 border border-red-500/20">
                                🛡️ Admin
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-800 text-gray-400">
                                👤 Estudiante
                            </span>
                            @endif
                        </td>

                        {{-- Level --}}
                        <td class="px-6 py-4 text-gray-300 text-xs font-medium">
                            {{ $user->level?->icon ?? '⭐' }} {{ $user->level?->name ?? 'Nivel 1' }}
                        </td>

                        {{-- XP --}}
                        <td class="px-6 py-4">
                            <span class="font-bold text-blue-400">
                                {{ number_format($user->xp) }} XP
                            </span>
                        </td>

                        {{-- Streak --}}
                        <td class="px-6 py-4">
                            <span class="text-orange-400 font-semibold text-xs flex items-center gap-1">
                                🔥 {{ $user->streak_days }} {{ Str::plural('día', $user->streak_days) }}
                            </span>
                        </td>

                        {{-- Joined --}}
                        <td class="px-6 py-4 text-gray-500 text-xs">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if(!$user->is_admin)
                                <form method="POST" action="{{ route('admin.users.makeAdmin', $user) }}" onsubmit="return confirm('¿Convertir a {{ addslashes($user->name) }} en Administrador?')">
                                    @csrf
                                    <button type="submit"
                                            class="px-3 py-1.5 bg-blue-600/15 hover:bg-blue-600/30 text-blue-400 border border-blue-500/20 rounded-lg text-xs font-bold transition flex items-center gap-1">
                                        🛡️ Hacer Admin
                                    </button>
                                </form>
                                @else
                                    @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.removeAdmin', $user) }}" onsubmit="return confirm('¿Quitar privilegios de Administrador a {{ addslashes($user->name) }}?')">
                                        @csrf
                                        <button type="submit"
                                                class="px-3 py-1.5 bg-red-600/15 hover:bg-red-600/30 text-red-400 border border-red-500/20 rounded-lg text-xs font-bold transition flex items-center gap-1">
                                            ⚠️ Quitar Admin
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-xs text-gray-500 font-medium px-2 py-1 bg-gray-800/40 rounded-lg">
                                        (Tu cuenta)
                                    </span>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500 text-sm">
                            No se encontraron usuarios que coincidan con la búsqueda.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
    <div class="mt-6">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
