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
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-surface-container-lowest text-on-surface">
    <main class="min-h-screen">
        {{ $slot }}
    </main>
</body>
</html>
