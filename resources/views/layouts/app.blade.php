<!DOCTYPE html>
<html lang="en">
<head>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @vite('resources/css/app.css')

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Elegant Library Manager')</title>
    <link rel="icon" type="image/x-icon" href="/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #18181b;
        }

        ::-webkit-scrollbar-thumb {
            background: #505054;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #6a6a6d;
        }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .category-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .category-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
    <script>
        // Optional: Define custom colors for better accuracy
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'twitch-bg-dark': '#0e0e10',     // Main background
                        'twitch-bg-header': '#1f1f23',  // Header background
                        'twitch-bg-sidebar': '#18181b', // Sidebar background
                        'twitch-bg-card': '#0e0e10',     // Card background (same as main)
                        'twitch-bg-hover': '#2f2f35',   // Generic hover background
                        'twitch-purple': '#9147ff',     // Twitch purple (not used here but common)
                        'twitch-pink': '#ef3fa0',      // Category pink
                        'twitch-gray-light': '#adadb8', // Lighter gray text
                        'twitch-gray-dark': '#505054',   // Darker gray elements/borders
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-twitch-bg-dark text-white font-sans">
    <!-- Navigation -->
    <x-nav-bar />

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
