<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — InitCode</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-950 text-white min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-900 border-r border-gray-800 
                  flex flex-col fixed h-full z-10">
        <div class="p-5 border-b border-gray-800">
            <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">
                Panel de Control
            </p>
            <h1 class="text-lg font-black bg-gradient-to-r from-blue-400 
                       to-green-400 bg-clip-text text-transparent">
                ⚡ InitCode Admin
            </h1>
        </div>

        <nav class="flex-1 p-3 space-y-1 overflow-y-auto">

            <p class="text-xs text-gray-600 uppercase tracking-widest 
                      px-3 py-2 mt-1">General</p>

            <a href="{{ route('admin.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg 
                      text-sm font-medium transition
                      {{ (request()->routeIs('admin.index') && (!request()->has('tab') || request()->query('tab') === 'dashboard'))
                          ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' 
                          : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                📊 Dashboard
            </a>

            <p class="text-xs text-gray-600 uppercase tracking-widest 
                      px-3 py-2 mt-3">Contenido</p>

            <a href="{{ route('admin.index', ['tab' => 'courses']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg 
                      text-sm font-medium transition
                      {{ (request()->routeIs('admin.index') && request()->query('tab') === 'courses') 
                          ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' 
                          : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                📚 Cursos
            </a>

            <a href="{{ route('admin.index', ['tab' => 'achievements']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg 
                      text-sm font-medium transition
                      {{ (request()->routeIs('admin.index') && request()->query('tab') === 'achievements') 
                          ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' 
                          : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                🏆 Logros
            </a>

            <p class="text-xs text-gray-600 uppercase tracking-widest 
                      px-3 py-2 mt-3">Usuarios</p>

            <a href="{{ route('admin.users') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg 
                      text-sm font-medium transition
                      {{ request()->routeIs('admin.users*') 
                          ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' 
                          : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                👥 Usuarios
            </a>
        </nav>

        <div class="p-4 border-t border-gray-800 space-y-2">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg 
                      text-gray-400 hover:text-white hover:bg-gray-800 
                      transition text-sm font-medium w-full">
                ← Volver a InitCode
            </a>
            <div class="px-3 py-2">
                <p class="text-xs text-gray-600 truncate">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-gray-700 truncate">
                    {{ auth()->user()->email }}
                </p>
            </div>
        </div>
    </aside>

    <main class="ml-64 flex-1 min-h-screen">

        @if(session('success'))
        <div class="mx-6 mt-4 p-4 bg-green-500/10 border border-green-500/30 
                    rounded-xl text-green-400 text-sm font-medium">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mx-6 mt-4 p-4 bg-red-500/10 border border-red-500/30 
                    rounded-xl text-red-400 text-sm font-medium">
            {{ session('error') }}
        </div>
        @endif

        @if(isset($errors) && $errors->any())
        <div class="mx-6 mt-4 p-4 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm font-medium">
            <p class="font-bold mb-1.5 flex items-center gap-1.5">⚠️ Por favor corrige los siguientes errores:</p>
            <ul class="list-disc list-inside space-y-1 text-xs text-red-300">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Top bar --}}
        <div class="sticky top-0 z-10 bg-gray-950/95 backdrop-blur 
                    border-b border-gray-800 px-8 py-3 flex items-center 
                    justify-between">
            <div class="text-sm text-gray-500">
                @yield('breadcrumb', 'Admin')
            </div>
            <div class="text-sm text-gray-400">
                {{ auth()->user()->name }}
            </div>
        </div>

        <div class="p-8">
            @yield('content')
        </div>
    </main>

</body>
</html>
