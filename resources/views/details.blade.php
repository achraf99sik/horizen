<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $video->title }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.vidstack.io/player/theme.css" />
        <link rel="stylesheet" href="https://cdn.vidstack.io/player/video.css" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-stone-800 text-white ">
        <style>
            .player {
                width: 70%;
                aspect-ratio: unset;
                justify-self: center;
                margin-top: 4%;
            }
        </style>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Navbar Example</title>
            <!-- Include Tailwind CSS -->
            <script src="https://cdn.tailwindcss.com"></script>
            <style>
                /* Optional: Define custom colors if needed, matching the image */
                /* You can configure these in your tailwind.config.js */
                tailwind.config= {
                    theme: {
                        extend: {
                            colors: {
                                'navbar-bg': '#1f1f23', // Example dark background
                                    'brand-pink': '#ef3a83', // Example pink color
                                    'brand-orange': '#e9600f', // Example orange color
                                    'search-bg': '#3a3a3d', // Example search background
                                    'search-border': '#505054', // Example search border
                            }
                        }
                    }
                }
            </style>
        </head>

            <nav class="bg-navbar-bg text-white flex items-center justify-between px-4 py-2">
                <!-- Left Section: Logo, Links -->
                <div class="flex items-center space-x-4">
                    <!-- Logo Placeholder -->
                    <a href="#" class="flex-shrink-0">
                        <img width="50px" src="{{ asset('Logo.png') }}"  alt="">
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white font-semibold">Following</a>
                    <a href="#" class="text-white font-semibold border-b-2 border-brand-orange pb-[7px]">Browse</a>
                    <!-- Ellipsis Icon -->
                    <button class="text-gray-400 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                        </svg>
                    </button>
                </div>

                <!-- Center Section: Search -->
                <div class="flex-1 flex justify-center px-6 lg:px-10">
                    <div class="relative w-full max-w-xs lg:max-w-sm">
                        <input type="text" placeholder="Search"
                            class="bg-search-bg border border-search-border text-gray-200 placeholder-gray-400 rounded-md py-1.5 px-4 pl-10 block w-full focus:outline-none focus:ring-1 focus:ring-brand-pink focus:border-brand-pink" />
                        <!-- Search Icon -->
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Right Section: Icons -->
                <div class="flex items-center space-x-4">
                    <!-- Notification Icon with Badge -->
                    <button class="relative text-gray-400 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.017 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <!-- Badge -->
                        <span
                            class="absolute -top-2 -right-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-brand-pink rounded-full">70</span>
                    </button>

                    <!-- Inbox Icon -->
                    <button class="text-gray-400 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </button>

                    <!-- Profile Icon -->
                    <button>
                        <!-- SVG containing the pink circle and user icon -->
                        <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="16" cy="16" r="16" fill="#ef3a83" /> <!-- brand-pink -->
                            <path
                                d="M16 18C19.3137 18 22 15.3137 22 12C22 8.68629 19.3137 6 16 6C12.6863 6 10 8.68629 10 12C10 15.3137 12.6863 18 16 18ZM16 20C11.5817 20 8 21.7909 8 24V26H24V24C24 21.7909 20.4183 20 16 20Z"
                                fill="white" />
                        </svg>
                    </button>
                </div>
            </nav>

        <div class="w-1/2 player mb-20">
            <media-player title="{{ $video->title }}" src="{{ route("video.playlist", [$video->slug, 'index.m3u8']) }}">
                <media-provider></media-provider>
                <media-video-layout></media-video-layout>
            </media-player>
            <h1 class="font-bold text-xl">{{ $video->title }}</h1>
            <div class="flex justify-between">
                <div class="flex align-middle gap-4 items-center">
                    <div class="w-12 h-12 rounded-full bg-pink-300"></div>
                    <h3 class="text-xl">{{ $video->user->name }}</h3>
                    <button class="bg-pink-600 rounded-full p-2 font-semibold">Subscribe</button>
                </div>
                <div class="flex align-middle gap-4 items-center">
                    <div class="flex align-middle items-center">
                        <button class="bg-pink-600 rounded-l-full p-2 font-medium">Like</button>
                        <button class="bg-black rounded-r-full p-2 font-medium">Dislike</button>
                    </div>
                    <button class="bg-black rounded-full p-2 font-medium">Share</button>
                    <button class="bg-black rounded-full p-2 font-medium">Download</button>
                    <button class="bg-black rounded-full w-10 h-10 font-semibold">...</button>
                </div>
            </div>
        </div>
        <script src="https://cdn.vidstack.io/player" type="module"></script>
    </body>
</html>
