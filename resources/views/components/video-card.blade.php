@props(['slug'=>'null', 'title' => 'Untitled', 'views' => '19,210,251', 'date' => 'Jul 1, 2016', 'thumbnail' => 'https://i.ytimg.com/vi/IsXvoYeVIaI/hq720.jpg?sqp=-oaymwEcCOgCEMoBSFXyq4qpAw4IARUAAIhCGAFwAcABBg==&rs=AOn4CLD_p76hY0G6xL7J1kP2h9kG9p9p_A'])
<a href="watch/{{ $slug }}">
    <div class="max-w-sm rounded-lg overflow-hidden shadow-lg">
        <div>
            <img class="w-full h-auto object-cover"
                src="{{ $thumbnail }}"
                alt="Video thumbnail showing a large moon over mountains in a pinkish sky">
        </div>

        <div class="p-3 flex items-start space-x-3">
            <button>
                <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="16" cy="16" r="16" fill="#ef3a83" />
                    <path
                        d="M16 18C19.3137 18 22 15.3137 22 12C22 8.68629 19.3137 6 16 6C12.6863 6 10 8.68629 10 12C10 15.3137 12.6863 18 16 18ZM16 20C11.5817 20 8 21.7909 8 24V26H24V24C24 21.7909 20.4183 20 16 20Z"
                        fill="white" />
                </svg>
            </button>

            <div class="flex-1 min-w-0">
                <h3 class="text-white font-semibold text-base leading-snug line-clamp-2 mb-1">
                    {{ $title }}
                </h3>
                <p class="text-gray-400 text-sm">
                    {{ $views }} views <span class="mx-1">·</span> {{ $date }}
                </p>
            </div>

            <div class="flex-shrink-0">
                <button class="text-gray-400 hover:text-white p-1 -mr-1" aria-label="More options">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</a>
