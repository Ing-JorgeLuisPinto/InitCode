<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CodePath') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-low": "#161b2b",
                        "surface-container-highest": "#2f3445",
                        "error": "#ffb4ab",
                        "on-background": "#dee1f7",
                        "on-tertiary": "#5d1900",
                        "background": "#0e1322",
                        "on-secondary": "#003918",
                        "surface": "#0e1322",
                        "primary-fixed-dim": "#acc7ff",
                        "tertiary-fixed-dim": "#ffb59d",
                        "on-surface-variant": "#c2c6d5",
                        "surface-bright": "#343949",
                        "error-container": "#93000a",
                        "surface-container": "#1a1f2f",
                        "on-primary-container": "#00285b",
                        "on-surface": "#dee1f7",
                        "on-primary-fixed": "#001a40",
                        "on-error-container": "#ffdad6",
                        "inverse-on-surface": "#2b3040",
                        "primary-fixed": "#d7e2ff",
                        "secondary-container": "#00ea78",
                        "on-tertiary-fixed-variant": "#832600",
                        "primary-container": "#508ff8",
                        "surface-container-lowest": "#090e1c",
                        "secondary-fixed-dim": "#00e475",
                        "surface-dim": "#0e1322",
                        "surface-container-high": "#25293a",
                        "tertiary-fixed": "#ffdbd0",
                        "surface-variant": "#2f3445",
                        "on-secondary-fixed-variant": "#005226",
                        "on-primary": "#002f68",
                        "surface-tint": "#acc7ff",
                        "inverse-primary": "#005bbf",
                        "on-secondary-fixed": "#00210b",
                        "outline-variant": "#424753",
                        "tertiary-container": "#f3632d",
                        "secondary": "#93ffad",
                        "inverse-surface": "#dee1f7",
                        "tertiary": "#ffb59d",
                        "on-tertiary-container": "#511500",
                        "on-error": "#690005",
                        "on-secondary-container": "#00642f",
                        "on-primary-fixed-variant": "#004492",
                        "on-tertiary-fixed": "#390c00",
                        "primary": "#acc7ff",
                        "outline": "#8c909e",
                        "secondary-fixed": "#62ff96"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "sidebar_width": "256px",
                        "base_unit": "8px",
                        "radius_md": "12px",
                        "topbar_height": "72px",
                        "container_gap": "24px",
                        "radius_lg": "16px"
                    },
                    "fontFamily": {
                        "h2": ["Space Grotesk"],
                        "code-md": ["JetBrains Mono"],
                        "h1": ["Space Grotesk"],
                        "body-lg": ["Plus Jakarta Sans"],
                        "label-caps": ["Space Grotesk"],
                        "display": ["Space Grotesk"],
                        "body-md": ["Plus Jakarta Sans"]
                    },
                    "fontSize": {
                        "h2": ["24px", {"lineHeight": "1.3", "fontWeight": "600"}],
                        "code-md": ["14px", {"lineHeight": "1.5", "fontWeight": "450"}],
                        "h1": ["32px", {"lineHeight": "1.2", "fontWeight": "700"}],
                        "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "label-caps": ["12px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "700"}],
                        "display": ["48px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "body-md": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}]
                    }
                },
            },
        }
    </script>

    <style>
        body {
            background-color: #0A0F1E;
            color: #dee1f7;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glow-blue { box-shadow: 0 0 20px rgba(79, 142, 247, 0.2); }
        .glow-orange { box-shadow: 0 0 20px rgba(243, 99, 45, 0.2); }
        .glow-green { box-shadow: 0 0 20px rgba(0, 234, 120, 0.2); }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="overflow-x-hidden">
    <!-- SideNavBar -->
    <aside class="fixed left-0 top-0 h-full w-64 border-r border-[#1F2937] bg-[#0A0F1E] flex flex-col z-50">
        <div class="p-8">
            <a href="{{ route('dashboard') }}">
                <h1 class="text-2xl font-black bg-gradient-to-r from-blue-400 to-indigo-600 bg-clip-text text-transparent font-h1">CodePath</h1>
            </a>
            <p class="text-xs text-slate-400 font-label-caps mt-1">Aprende a programar</p>
        </div>
        <nav class="flex-1 px-4 space-y-2 mt-4">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="grid_view">Dashboard</x-nav-link>
            <x-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*')" icon="school">Cursos</x-nav-link>
            <x-nav-link :href="route('tutor.index')" :active="request()->routeIs('tutor.*')" icon="smart_toy">Tutor IA</x-nav-link>
            <x-nav-link :href="route('leaderboard.index')" :active="request()->routeIs('leaderboard.index')" icon="emoji_events">Clasificación</x-nav-link>
            <x-nav-link :href="route('profile.show')" :active="request()->routeIs('profile.*')" icon="person">Perfil</x-nav-link>
            
            @if(Auth::user()->is_admin)
            <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.*')" icon="settings">⚙️ Admin Panel</x-nav-link>
            @endif
        </nav>
        <div class="p-6 border-t border-[#1F2937] mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-surface-container rounded-xl p-4 flex items-center gap-3 hover:bg-surface-container-high transition-colors">
                    <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="text-left">
                        <p class="text-sm font-bold">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400">Cerrar Sesión</p>
                    </div>
                </button>
            </form>
        </div>
    </aside>

    <!-- TopNavBar -->
    <header class="fixed top-0 right-0 h-[72px] left-64 w-[calc(100%-16rem)] flex justify-end items-center px-8 z-40 bg-[#0A0F1E]/80 backdrop-blur-md border-b border-[#1F2937] shadow-xl shadow-black/20">
        <div class="flex items-center gap-6">
            @php
                $streakUser = auth()->user();
                $streakActive = $streakUser->last_activity_date && 
                    \Carbon\Carbon::parse($streakUser->last_activity_date)->isToday();
            @endphp

            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full
                        {{ $streakActive ? 'bg-orange-500/20 border border-orange-500/40' : 'bg-gray-800 border border-gray-700' }}">
                <span class="{{ $streakActive ? 'animate-pulse' : 'opacity-50' }} text-lg">🔥</span>
                <span class="{{ $streakActive ? 'text-orange-400 font-bold' : 'text-gray-500' }} text-sm">
                    {{ $streakUser->streak_days ?? 0 }}
                </span>
            </div>
            <div class="flex items-center gap-2 bg-surface-container-high px-4 py-2 rounded-full border border-[#1F2937]">
                <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">military_tech</span>
                <span class="font-h2 text-sm text-secondary">{{ Auth::user()->level->level_number ?? 1 }}</span>
            </div>
            <button class="material-symbols-outlined text-slate-400 hover:text-white">notifications</button>
            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-primary">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=508ff8&color=fff" alt="{{ Auth::user()->name }}">
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="ml-64 pt-[104px] p-8 min-h-screen bg-background">
        {{ $slot }}
    </main>
</body>
</html>
