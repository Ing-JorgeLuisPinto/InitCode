@extends('admin.layout')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold">Dashboard Admin</h2>
    <p class="text-slate-400">Resumen general de la plataforma</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <div class="p-6 rounded-2xl bg-surface border border-slate-800">
        <p class="text-slate-400 text-sm font-semibold mb-2">USUARIOS</p>
        <p class="text-3xl font-bold">{{ $stats['total_users'] }}</p>
    </div>
    <div class="p-6 rounded-2xl bg-surface border border-slate-800">
        <p class="text-slate-400 text-sm font-semibold mb-2">CURSOS</p>
        <p class="text-3xl font-bold">{{ $stats['total_courses'] }}</p>
    </div>
    <div class="p-6 rounded-2xl bg-surface border border-slate-800">
        <p class="text-slate-400 text-sm font-semibold mb-2">LECCIONES</p>
        <p class="text-3xl font-bold">{{ $stats['total_lessons'] }}</p>
    </div>
    <div class="p-6 rounded-2xl bg-surface border border-slate-800">
        <p class="text-slate-400 text-sm font-semibold mb-2">EJERCICIOS</p>
        <p class="text-3xl font-bold">{{ $stats['total_exercises'] }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Users -->
    <div class="bg-surface rounded-2xl border border-slate-800 overflow-hidden">
        <div class="p-6 border-b border-slate-800">
            <h3 class="font-bold">Usuarios Recientes</h3>
        </div>
        <div class="divide-y divide-slate-800">
            @foreach($stats['recent_users'] as $user)
            <div class="p-4 flex items-center justify-between">
                <div>
                    <p class="font-semibold text-sm">{{ $user->name }}</p>
                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                </div>
                <span class="text-xs px-2 py-1 rounded bg-slate-800 text-slate-400">
                    {{ $user->created_at->diffForHumans() }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Top Users -->
    <div class="bg-surface rounded-2xl border border-slate-800 overflow-hidden">
        <div class="p-6 border-b border-slate-800">
            <h3 class="font-bold">Top Usuarios</h3>
        </div>
        <div class="divide-y divide-slate-800">
            @foreach($stats['top_users'] as $user)
            <div class="p-4 flex items-center justify-between">
                <div>
                    <p class="font-semibold text-sm">{{ $user->name }}</p>
                    <p class="text-xs text-slate-500">Nivel: {{ $user->level->name ?? 'N/A' }}</p>
                </div>
                <span class="text-xs px-2 py-1 rounded bg-slate-800 text-slate-400">
                    {{ $user->xp }} XP
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
