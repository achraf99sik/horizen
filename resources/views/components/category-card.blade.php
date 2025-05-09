@props(['id' => '1', 'name' => 'Untitled'])
<a href="/Categories/{{ $id }}"
    class="bg-twitch-pink h-8 w-36 relative text-white font-semibold py-2 px-4 rounded-md flex items-center space-x-2 hover:bg-black whitespace-nowrap flex-shrink-0">
    <span>{{ ucfirst($name) }}</span>
    <!-- Placeholder Icon - Replace with actual game icon -->
    <div class="pb-14">
        <div class="absolute z-30">
            @switch($name)
                @case('games')
                    <img class="w-20 h-16" src="{{ asset('images/joy.svg') }}" alt="">
                    @break

                @case('podcasts')
                    <img class="w-20 h-16" src="{{ asset('images/mic.svg') }}" alt="">
                    @break

                @case('music')
                    <img class="w-20 h-16" src="{{ asset('images/music.svg') }}" alt="">
                    @break

                @case('creative')
                    <img class="w-20 h-16" src="{{ asset('images/paint.svg') }}" alt="">
                    @break

                @case('esports')
                    <img class="w-20 h-16" src="{{ asset('images/trophy.svg') }}" alt="">
                    @break

                @default

            @endswitch
        </div>
    </div>
</a>
