@extends('layouts.app')

@section('title', 'Home')

@section('content')




    <div class="flex" style="height: calc(100vh - 56px);"> <!-- Full height minus header -->

        <!-- Sidebar (sticky within flex item) -->
        <aside class="w-60 bg-twitch-bg-sidebar p-3 flex-shrink-0 sticky top-14 h-full">
            <!-- For You Section -->
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="text-xs uppercase font-semibold text-twitch-gray-light tracking-wider">For You</h4>
                    <button class="text-twitch-gray-light hover:text-white" title="Collapse">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M14.77 12.79a.75.75 0 0 1-1.06-.02L10 8.832 6.29 12.77a.75.75 0 1 1-1.08-1.04l4.25-4.5a.75.75 0 0 1 1.08 0l4.25 4.5a.75.75 0 0 1-.02 1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <h5 class="text-sm font-semibold mb-2 ml-1">FOLLOWED CHANNELS</h5>
                <ul>
                    <!-- Example Followed Channels (Repeat as needed) -->
                    <li class="mb-1"><a href="#"
                            class="flex items-center space-x-2 py-1 px-1 rounded hover:bg-twitch-bg-hover"><img
                                class="w-6 h-6 rounded-full"
                                src="https://static-cdn.jtvnw.net/jtv_user_pictures/cd620f56-f789-4dfb-a952-1328041e9b89-profile_image-70x70.png"
                                alt=""><span class="text-sm truncate">sinatraa</span></a></li>
                    <li class="mb-1"><a href="#"
                            class="flex items-center space-x-2 py-1 px-1 rounded hover:bg-twitch-bg-hover"><img
                                class="w-6 h-6 rounded-full"
                                src="https://static-cdn.jtvnw.net/jtv_user_pictures/f4ee91ba-1d77-460b-a614-a07651945197-profile_image-70x70.png"
                                alt=""><span class="text-sm truncate">Subroza</span></a></li>
                    <li class="mb-1"><a href="#"
                            class="flex items-center space-x-2 py-1 px-1 rounded hover:bg-twitch-bg-hover"><img
                                class="w-6 h-6 rounded-full"
                                src="https://static-cdn.jtvnw.net/jtv_user_pictures/01235450-e6f5-414a-9b93-5095d61a45cf-profile_image-70x70.png"
                                alt=""><span class="text-sm truncate">ESLCS</span></a></li>
                    <li class="mb-1"><a href="#"
                            class="flex items-center space-x-2 py-1 px-1 rounded hover:bg-twitch-bg-hover"><img
                                class="w-6 h-6 rounded-full"
                                src="https://static-cdn.jtvnw.net/jtv_user_pictures/17a1562b-7f03-434f-b76f-0f3b3b101ff4-profile_image-70x70.png"
                                alt=""><span class="text-sm truncate">schrodingerLee</span></a></li>
                    <li class="mb-1"><a href="#"
                            class="flex items-center space-x-2 py-1 px-1 rounded hover:bg-twitch-bg-hover"><img
                                class="w-6 h-6 rounded-full"
                                src="https://static-cdn.jtvnw.net/jtv_user_pictures/8d429715-1b09-471f-9645-81f34a539cb7-profile_image-70x70.png"
                                alt=""><span class="text-sm truncate">Caedrel</span></a></li>
                    <!-- ... more channels -->
                    <li><button class="text-xs text-twitch-pink hover:underline ml-1">Show More</button></li>
                </ul>
            </div>

            <!-- Recommended Channels Section -->
            <div class="mb-4">
                <h5 class="text-sm font-semibold mb-2 ml-1">RECOMMENDED CHANNELS</h5>
                <ul>
                    <!-- Example Recommended Channels (Repeat as needed) -->
                    <li class="mb-1"><a href="#"
                            class="flex items-center space-x-2 py-1 px-1 rounded hover:bg-twitch-bg-hover"><img
                                class="w-6 h-6 rounded-full"
                                src="https://static-cdn.jtvnw.net/jtv_user_pictures/ff0cb160-b6f8-4928-ab5e-c9789dc8e1b0-profile_image-70x70.png"
                                alt=""><span class="text-sm truncate">shanks_ttv</span></a></li>
                    <li class="mb-1"><a href="#"
                            class="flex items-center space-x-2 py-1 px-1 rounded hover:bg-twitch-bg-hover"><img
                                class="w-6 h-6 rounded-full"
                                src="https://static-cdn.jtvnw.net/jtv_user_pictures/06a07a30-03e1-48fe-a358-89be48057306-profile_image-70x70.png"
                                alt=""><span class="text-sm truncate">Emmyuh</span></a></li>
                    <li class="mb-1"><a href="#"
                            class="flex items-center space-x-2 py-1 px-1 rounded hover:bg-twitch-bg-hover"><img
                                class="w-6 h-6 rounded-full"
                                src="https://static-cdn.jtvnw.net/jtv_user_pictures/cb66019c-8126-4413-a2a7-1216c18446a8-profile_image-70x70.jpg"
                                alt=""><span class="text-sm truncate">joshseki</span></a></li>
                    <li class="mb-1"><a href="#"
                            class="flex items-center space-x-2 py-1 px-1 rounded hover:bg-twitch-bg-hover"><img
                                class="w-6 h-6 rounded-full"
                                src="https://static-cdn.jtvnw.net/jtv_user_pictures/16e41e3b-0b64-4330-8685-d186f8bf79bf-profile_image-70x70.png"
                                alt=""><span class="text-sm truncate">ShivFPS</span></a></li>
                    <li class="mb-1"><a href="#"
                            class="flex items-center space-x-2 py-1 px-1 rounded hover:bg-twitch-bg-hover"><img
                                class="w-6 h-6 rounded-full"
                                src="https://static-cdn.jtvnw.net/jtv_user_pictures/35c0d5ac-65d0-4bee-8a7d-6486f52178a7-profile_image-70x70.png"
                                alt=""><span class="text-sm truncate">HisWattson</span></a></li>
                    <li class="mb-1"><a href="#"
                            class="flex items-center space-x-2 py-1 px-1 rounded hover:bg-twitch-bg-hover"><img
                                class="w-6 h-6 rounded-full"
                                src="https://static-cdn.jtvnw.net/jtv_user_pictures/28d84913-f186-4c97-9176-3a46f6a505cc-profile_image-70x70.png"
                                alt=""><span class="text-sm truncate">Woohoojin</span></a></li>
                    <!-- ... more channels -->
                    <li><button class="text-xs text-twitch-pink hover:underline ml-1">Show More</button></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content Grid Area -->
        <main class="flex-1 p-6  h-full">
            <h1 class="text-5xl font-bold mb-6">Browse</h1>
            <!-- Category Filters -->
            <div class="flex space-x-3 mb-6 overflow-x-auto max-w-4xl pb-2 category-scrollbar">
                <!-- Example Categories (Add more) -->
                <a href="category/games"
                    class="bg-twitch-pink h-8 w-36 text-white font-semibold py-2 px-4 rounded-md flex items-center space-x-2 hover:bg-black whitespace-nowrap flex-shrink-0">
                    <span>Games</span>
                    <!-- Placeholder Icon - Replace with actual game icon -->
                    <div class="pb-16">
                        <div class="absolute stick mt-2">
                            <img src="{{ asset('images/joy.svg') }}" alt="">
                        </div>
                    </div>
                </a>
                <a href="category/games"
                    class="bg-twitch-pink h-8 w-36 text-white font-semibold py-2 px-4 rounded-md flex items-center space-x-2 hover:bg-black whitespace-nowrap flex-shrink-0">
                    <span>Games</span>
                    <!-- Placeholder Icon - Replace with actual game icon -->
                    <div class="pb-16">
                        <div class="absolute mt-2">
                            <img src="{{ asset('images/joy.svg') }}" alt="">
                        </div>
                    </div>
                </a>
                <a href="category/games"
                    class="bg-twitch-pink h-8 w-36 text-white font-semibold py-2 px-4 rounded-md flex items-center space-x-2 hover:bg-black whitespace-nowrap flex-shrink-0">
                    <span>Games</span>
                    <!-- Placeholder Icon - Replace with actual game icon -->
                    <div class="pb-16">
                        <div class="absolute mt-2">
                            <img src="{{ asset('images/joy.svg') }}" alt="">
                        </div>
                    </div>
                </a>
                <a href="category/games"
                    class="bg-twitch-pink h-8 w-36 text-white font-semibold py-2 px-4 rounded-md flex items-center space-x-2 hover:bg-black whitespace-nowrap flex-shrink-0">
                    <span>Games</span>
                    <!-- Placeholder Icon - Replace with actual game icon -->
                    <div class="pb-16">
                        <div class="absolute mt-2">
                            <img src="{{ asset('images/joy.svg') }}" alt="">
                        </div>
                    </div>
                </a>
                <a href="category/podcasts"
                    class="bg-twitch-pink overflow-y-visible bg-twitch-pink h-8 w-36 text-white font-semibold py-2 px-4 rounded-md flex items-center space-x-2 hover:bg-black whitespace-nowrap flex-shrink-0">
                    <span>Podcasts</span>
                    <!-- Placeholder Icon - Replace with actual game icon -->
                    <div class="pb-16">
                        <div class="absolute mt-2">
                            <img src="{{ asset('images/mic.svg') }}" alt="">
                        </div>
                    </div>
                </a>
                <a href="category/music"
                    class="bg-twitch-pink overflow-y-visible h-8 w-36 text-white font-semibold py-2 px-4 rounded-md flex items-center space-x-2 hover:bg-black whitespace-nowrap flex-shrink-0">
                    <span>Music</span>
                    <!-- Placeholder Icon - Replace with actual game icon -->
                    <div class="pb-16">
                        <div class="absolute mt-2">
                            <img src="{{ asset('images/music.svg') }}" alt="">
                        </div>
                    </div>
                </a>
                <a href="category/creative"
                    class="bg-twitch-pink overflow-y-visible h-8 w-36 text-white font-semibold py-2 px-4 rounded-md flex items-center space-x-2 hover:bg-black whitespace-nowrap flex-shrink-0">
                    <span>Creative</span>
                    <!-- Placeholder Icon - Replace with actual game icon -->
                    <div class="pb-16">
                        <div class="absolute mt-2">
                            <img src="{{ asset('images/paint.svg') }}" alt="">
                        </div>
                    </div>
                </a>
                <a href="category/esports"
                    class="bg-twitch-pink overflow-y-visible h-8 w-36 text-white font-semibold py-2 px-4 rounded-md flex items-center space-x-2 hover:bg-black whitespace-nowrap flex-shrink-0">
                    <span>Esports</span>
                    <!-- Placeholder Icon - Replace with actual game icon -->
                    <div class="pb-16">
                        <div class="absolute mt-2">
                            <img src="{{ asset('images/trophy.svg') }}" alt="">
                        </div>
                    </div>
                </a>

                <!-- ... Add more categories -->
            </div>

            <!-- Video Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-x-4 gap-y-8">
                @foreach ($video as $v)
                    <x-video-card slug="{{ $v->slug }}" title="{{ $v->title }}" thumbnail="{{ Storage::url($v->thumbnail) }}" views="{{ number_format($v->viewer_count) }}" date="{{ date_format($v->created_at, 'M j, Y')}}" />
                @endforeach
            </div>
        </main>

    </div>
@endsection
