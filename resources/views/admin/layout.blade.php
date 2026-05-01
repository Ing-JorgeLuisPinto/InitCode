<!DOCTYPE html>
<html class="dark" lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - CodePath</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        background: '#0e1322',
                        surface: '#161b2b',
                        primary: '#acc7ff',
                        secondary: '#93ffad',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0e1322; color: #dee1f7; }
        h1, h2, h3 { font-family: 'Space Grotesk', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-64 border-r border-slate-800 bg-surface flex flex-col fixed h-full">
        <div class="p-8">
            <h1 class="text-2xl font-black bg-gradient-to-r from-blue-400 to-indigo-600 bg-clip-text text-transparent">Admin CP</h1>
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('admin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-colors {{ request()->routeIs('admin.index') ? 'bg-slate-800 text-primary' : '' }}">
                <span class="material-symbols-outlined">dashboard</span> Dashboard
            </a>
            <a href="{{ route('admin.courses') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-colors {{ request()->routeIs('admin.courses*') ? 'bg-slate-800 text-primary' : '' }}">
                <span class="material-symbols-outlined">school</span> Cursos
            </a>
            <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-colors {{ request()->routeIs('admin.users*') ? 'bg-slate-800 text-primary' : '' }}">
                <span class="material-symbols-outlined">group</span> Usuarios
            </a>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-colors mt-10">
                <span class="material-symbols-outlined">arrow_back</span> Volver a la App
            </a>
        </nav>
    </aside>

    <!-- Main -->
    <main class="flex-1 ml-64 p-8">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
