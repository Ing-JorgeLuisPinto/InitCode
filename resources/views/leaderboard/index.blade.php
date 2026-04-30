<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-10">
        <header class="text-center space-y-4">
            <div class="w-20 h-20 bg-secondary/20 text-secondary rounded-full flex items-center justify-center text-4xl mx-auto shadow-2xl">
                🏆
            </div>
            <h1 class="text-4xl font-black text-on-surface">Tabla de Clasificación</h1>
            <p class="text-on-surface-variant text-lg">Los mejores programadores de la comunidad.</p>
        </header>

        <div class="bg-surface-container border border-outline-variant rounded-3xl overflow-hidden shadow-2xl">
            <table class="w-full">
                <thead>
                    <tr class="bg-surface-container-high border-b border-outline-variant text-left">
                        <th class="px-8 py-6 text-xs font-bold uppercase tracking-widest text-slate-400">Puesto</th>
                        <th class="px-8 py-6 text-xs font-bold uppercase tracking-widest text-slate-400">Usuario</th>
                        <th class="px-8 py-6 text-xs font-bold uppercase tracking-widest text-slate-400">Nivel</th>
                        <th class="px-8 py-6 text-right text-xs font-bold uppercase tracking-widest text-slate-400">Puntos (XP)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1F2937]">
                    @foreach($users as $user)
                    <tr class="hover:bg-surface-container-high transition-colors {{ $user->id === Auth::id() ? 'bg-primary/5' : '' }}">
                        <td class="px-8 py-6">
                            <div class="w-10 h-10 rounded-full {{ $loop->iteration <= 3 ? 'bg-secondary text-on-secondary' : 'bg-surface-container-low text-slate-400' }} flex items-center justify-center font-black">
                                @if($loop->iteration == 1) 🥇 @elseif($loop->iteration == 2) 🥈 @elseif($loop->iteration == 3) 🥉 @else {{ $loop->iteration }} @endif
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full overflow-hidden border border-outline-variant">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=161b2b&color=dee1f7" alt="{{ $user->name }}">
                                </div>
                                <div>
                                    <p class="font-bold text-on-surface">{{ $user->name }}</p>
                                    @if($user->id === Auth::id())
                                    <span class="text-[10px] bg-primary/20 text-primary px-2 py-0.5 rounded font-black uppercase">Tú</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="bg-surface-container-highest px-3 py-1 rounded-full text-xs font-bold">{{ $user->level->name ?? 'Nivel 1' }}</span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <span class="text-xl font-black text-primary">{{ number_format($user->xp) }}</span>
                            <span class="text-xs font-bold text-slate-500 ml-1 uppercase">XP</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
