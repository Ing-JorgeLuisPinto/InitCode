<x-app-layout>
<div class="p-6 max-w-3xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-white mb-1">🔔 Notificaciones</h1>
            <p class="text-gray-400">Tu historial de actividad</p>
        </div>
        @if($notifications->total() > 0)
        <form method="POST" action="{{ route('notifications.read-all') }}">
            @csrf
            <button type="submit"
                    class="px-4 py-2 bg-gray-800 hover:bg-gray-700
                           text-gray-300 rounded-xl text-sm transition">
                ✓ Marcar todas como leídas
            </button>
        </form>
        @endif
    </div>

    @if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-500/20 border border-green-500/30
                text-green-400 rounded-xl text-sm">
        {{ session('success') }}
    </div>
    @endif

    @if($notifications->isEmpty())
    <div class="text-center py-20">
        <p class="text-6xl mb-4">🔔</p>
        <h2 class="text-xl font-bold text-white mb-2">Sin notificaciones</h2>
        <p class="text-gray-400">Aquí aparecerán tus logros, cambios de nivel y más</p>
    </div>
    @else
    <div class="space-y-3">
        @foreach($notifications as $notif)
        <div class="p-4 bg-gray-900 border rounded-xl transition
                    {{ $notif->read
                        ? 'border-gray-800 opacity-70'
                        : 'border-blue-500/30 bg-blue-500/5' }}">
            <div class="flex items-start gap-4">
                <span class="text-3xl flex-shrink-0">{{ $notif->icon }}</span>
                <div class="flex-1">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="font-bold text-white text-sm">
                                {{ $notif->title }}
                                @if(!$notif->read)
                                <span class="ml-2 px-2 py-0.5 bg-blue-600
                                             text-white text-xs rounded-full">
                                    Nueva
                                </span>
                                @endif
                            </p>
                            <p class="text-gray-400 text-sm mt-1">
                                {{ $notif->message }}
                            </p>
                        </div>
                        <p class="text-gray-600 text-xs whitespace-nowrap">
                            {{ $notif->created_at->diffForHumans() }}
                        </p>
                    </div>
                    @if($notif->link)
                    <form method="POST"
                          action="{{ route('notifications.read', $notif) }}"
                          class="mt-3">
                        @csrf
                        <button type="submit"
                                class="text-xs text-blue-400
                                       hover:text-blue-300 transition">
                            Ver detalles →
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
    @endif

</div>
</x-app-layout>
