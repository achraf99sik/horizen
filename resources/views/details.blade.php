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
                                'navbar-bg': '#1f1f23',
                                    'brand-pink': '#ef3a83',
                                    'brand-orange': '#e9600f',
                                    'search-bg': '#3a3a3d',
                                    'search-border': '#505054',
                            }
                        }
                    }
                }
            </style>
        </head>

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
                        <form class="inline">
                            <button type="submit" class="bg-pink-600 rounded-l-full p-2 font-medium text-white like-button"
                                data-video-id="{{ $video->id }}">
                                Like
                            </button>
                        </form>
                        <button class="bg-black rounded-r-full p-2 font-medium">Dislike</button>
                    </div>
                    <button class="bg-black rounded-full p-2 font-medium">Share</button>
                    <button class="bg-black rounded-full p-2 font-medium">Download</button>
                    <button class="bg-black rounded-full w-10 h-10 font-semibold">...</button>
                </div>
            </div>
        </div>
        <script src="https://cdn.vidstack.io/player" type="module"></script>
        <script>
            document.querySelectorAll('.like-button').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();

                    const videoId = this.getAttribute('data-video-id');
                    const token = localStorage.getItem('token');

                    if (!token) {
                        alert("You must be logged in to like.");
                        return;
                    }

                    fetch('/api/like', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ video_id: videoId })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status) {
                                if (data.action === 'liked') {
                                    this.innerText = 'Liked';
                                    this.classList.replace('bg-pink-600', 'bg-green-600');
                                } else {
                                    this.innerText = 'Like';
                                    this.classList.replace('bg-green-600', 'bg-pink-600');
                                }
                            } else {
                                console.error('Validation failed:', data.errors);
                            }
                        })
                        .catch(err => {
                            console.error('Request failed:', err);
                        });
                });
            });
        </script>

    </body>
</html>
