@extends('admin.layout')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold">Gestión de Usuarios</h2>
    <p class="text-slate-400">Listado total de usuarios registrados</p>
</div>

<div class="bg-surface rounded-2xl border border-slate-800 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-slate-800/50 text-slate-400 text-xs font-bold uppercase">
            <tr>
                <th class="px-6 py-4">Usuario</th>
                <th class="px-6 py-4">Nivel / XP</th>
                <th class="px-6 py-4">Estado</th>
                <th class="px-6 py-4">Registro</th>
                <th class="px-6 py-4">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800 text-sm">
            @foreach($users as $user)
            <tr class="hover:bg-slate-800/20 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center font-bold text-xs">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500">{{ $user->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <p class="font-bold text-primary">Nivel {{ $user->level->level_number ?? 1 }}</p>
                    <p class="text-xs text-slate-500">{{ $user->xp }} XP</p>
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        @if($user->is_admin)
                            <span class="px-2 py-1 rounded bg-indigo-500/10 text-indigo-400 text-xs font-bold uppercase">Admin</span>
                        @endif
                        @if($user->is_premium)
                            <span class="px-2 py-1 rounded bg-yellow-500/10 text-yellow-400 text-xs font-bold uppercase">Premium</span>
                        @else
                            <span class="px-2 py-1 rounded bg-slate-800 text-slate-500 text-xs font-bold uppercase">Gratis</span>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4 text-slate-400">{{ $user->created_at->format('d/m/Y') }}</td>
                <td class="px-6 py-4 flex gap-4">
                    <form action="{{ route('admin.users.premium', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-yellow-400 hover:underline">
                            {{ $user->is_premium ? 'Quitar Premium' : 'Hacer Premium' }}
                        </button>
                    </form>
                    
                    @if(!$user->is_admin)
                    <form action="{{ route('admin.users.delete', $user) }}" method="POST" onsubmit="return confirm('¿Eliminar usuario?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:underline">Eliminar</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection
