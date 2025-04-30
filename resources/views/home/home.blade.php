<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse - Twitch Clone</title>
    <!-- Include Tailwind CSS -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        /* Custom scrollbar styling (optional, for better look) */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #18181b;
            /* Sidebar bg or slightly darker */
        }

        ::-webkit-scrollbar-thumb {
            background: #505054;
            /* A gray color */
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #6a6a6d;
        }

        /* Basic line-clamp fallback if plugin isn't used */
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        /* Hide scrollbar for category filter, but allow scrolling */
        .category-scrollbar::-webkit-scrollbar {
            display: none;
            /* Safari and Chrome */
        }

        .category-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
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

    <!-- Header (sticky) -->
    <nav class="bg-twitch-bg-header text-white flex items-center justify-between px-4 py-2 sticky top-0 z-50 h-14">
        <!-- Left Section: Logo, Links -->
        <div class="flex items-center space-x-4">
            <a href="#" class="flex-shrink-0">
                <svg width="32" height="32" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <radialGradient id="grad1" cx="50%" cy="50%" r="50%" fx="50%" fy="50%">
                            <stop offset="0%" style="stop-color:rgb(0,0,0);stop-opacity:1" />
                            <stop offset="70%" style="stop-color:rgb(0,0,0);stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#4a004a;stop-opacity:1" />
                        </radialGradient>
                        <linearGradient id="grad2" x1="0%" y1="50%" x2="100%" y2="50%">
                            <stop offset="0%" style="stop-color:#ffcc66; stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#ffffff; stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#ffcc66; stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <ellipse cx="50" cy="50" rx="45" ry="25" fill="url(#grad2)" transform="rotate(-10 50 50)" />
                    <ellipse cx="50" cy="50" rx="35" ry="15" fill="url(#grad1)" transform="rotate(-10 50 50)" />
                    <circle cx="50" cy="50" r="15" fill="black" />
                </svg>
            </a>
            <a href="#" class="text-twitch-gray-light hover:text-white font-semibold">Following</a>
            <a href="#" class="text-white font-semibold border-b-2 border-orange-500 pb-[7px]">Browse</a>
            <button class="text-twitch-gray-light hover:text-white"><svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg></button>
        </div>
        <!-- Center Section: Search -->
        <div class="flex-1 flex justify-center px-6 lg:px-10">
            <div class="relative w-full max-w-xs lg:max-w-sm">
                <input type="text" placeholder="Search"
                    class="bg-[#3a3a3d] border border-[#505054] text-gray-200 placeholder-gray-400 rounded-md py-1.5 px-4 pl-10 block w-full focus:outline-none focus:ring-1 focus:ring-twitch-pink focus:border-twitch-pink" />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg
                        xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg></div>
            </div>
        </div>
        <!-- Right Section: Icons -->
        <div class="flex items-center space-x-4">
            <button class="relative text-twitch-gray-light hover:text-white"><svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.017 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg><span
                    class="absolute -top-2 -right-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-twitch-pink rounded-full">70</span></button>
            <button class="text-twitch-gray-light hover:text-white"><svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg></button>
            <button><svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="16" cy="16" r="16" fill="#ef3a83" />
                    <path
                        d="M16 18C19.3137 18 22 15.3137 22 12C22 8.68629 19.3137 6 16 6C12.6863 6 10 8.68629 10 12C10 15.3137 12.6863 18 16 18ZM16 20C11.5817 20 8 21.7909 8 24V26H24V24C24 21.7909 20.4183 20 16 20Z"
                        fill="white" />
                </svg></button>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="flex" style="height: calc(100vh - 56px);"> <!-- Full height minus header -->

        <!-- Sidebar (sticky within flex item) -->
        <aside class="w-60 bg-twitch-bg-sidebar p-3 flex-shrink-0 overflow-y-auto sticky top-14 h-full">
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
        <main class="flex-1 p-6 overflow-y-auto h-full">
            <h1 class="text-5xl font-bold mb-6">Browse</h1>

            <!-- Category Filters -->
            <div class="flex space-x-3 mb-6 overflow-x-auto pb-2 category-scrollbar">
                <!-- Example Categories (Add more) -->
                <a href="#"
                    class="bg-twitch-pink text-white font-semibold py-2 px-4 rounded-lg flex items-center space-x-2 hover:bg-pink-700 whitespace-nowrap flex-shrink-0">
                    <span>Games</span>
                    <!-- Placeholder Icon - Replace with actual game icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M12 1.75a2.25 2.25 0 0 1 2.25 2.25v3.025a.75.75 0 0 1-1.5 0V4a.75.75 0 0 0-.75-.75h-1.5a.75.75 0 0 0-.75.75v3.025a.75.75 0 0 1-1.5 0V4A2.25 2.25 0 0 1 12 1.75Zm-2.872 9.65a.75.75 0 0 0 1.058-.22L12 8.857l1.814 2.323a.75.75 0 1 0 1.278-.998l-2.25-2.883a.75.75 0 0 0-1.184 0l-2.25 2.883a.75.75 0 0 0 .164 1.22Z" />
                        <path fill-rule="evenodd"
                            d="M10.78 14.03a.75.75 0 0 1 0 1.06l-2.25 2.25a.75.75 0 0 1-1.06 0l-2.25-2.25a.75.75 0 1 1 1.06-1.06L7.5 15.19l1.03-1.03a.75.75 0 0 1 1.06 0Zm1.196-1.196a.75.75 0 0 0-1.06 0L9.72 14.03a.75.75 0 0 1-1.06 0L7.5 12.833l-.886.887a.75.75 0 0 0 0 1.06l2.25 2.25a.75.75 0 0 0 1.06 0l2.25-2.25a.75.75 0 0 0 0-1.06L11.977 12.833ZM18.75 16.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 .75-.75Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#"
                    class="bg-twitch-pink text-white font-semibold py-2 px-4 rounded-lg flex items-center space-x-2 hover:bg-pink-700 whitespace-nowrap flex-shrink-0">
                    <span>IRL</span>
                    <!-- Placeholder Icon - Replace with actual IRL icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.177A.75.75 0 0 0 8.75 9h6.5a.75.75 0 0 0 .728-.673 9.742 9.742 0 0 0-3.539-6.177.75.75 0 0 0-.475-.164Z"
                            clip-rule="evenodd" />
                        <path fill-rule="evenodd"
                            d="M19.5 10.5a.75.75 0 0 0-.75.75v2.25a.75.75 0 0 1-1.5 0v-2.25a.75.75 0 0 0-.75-.75h-1.5a.75.75 0 0 0-.75.75v2.25a.75.75 0 0 1-1.5 0v-2.25a.75.75 0 0 0-.75-.75h-1.5a.75.75 0 0 0-.75.75v2.25a.75.75 0 0 1-1.5 0v-2.25a.75.75 0 0 0-.75-.75H6a.75.75 0 0 0-.75.75v10.5a3 3 0 0 0 3 3h7.5a3 3 0 0 0 3-3V11.25a.75.75 0 0 0-.75-.75h-1.5Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#"
                    class="bg-twitch-pink text-white font-semibold py-2 px-4 rounded-lg flex items-center space-x-2 hover:bg-pink-700 whitespace-nowrap flex-shrink-0">
                    <span>Music</span>
                    <!-- Placeholder Icon - Replace with actual Music icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M19.952 1.651a.75.75 0 0 1 .298.599V16.25a4.5 4.5 0 0 1-9 0V8.321l-2.47-.823A.75.75 0 0 0 8 8.25v10.5a4.5 4.5 0 1 1-7.5-2.994V5.75a.75.75 0 0 1 .75-.75H8.5a.75.75 0 0 1 .693.441l1.958 4.307A3.001 3.001 0 0 0 14 12.25a3 3 0 0 0 5.952-1V2.25a.75.75 0 0 1 .952-.6ZM4 20.25a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM17 11.75a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#"
                    class="bg-twitch-pink text-white font-semibold py-2 px-4 rounded-lg flex items-center space-x-2 hover:bg-pink-700 whitespace-nowrap flex-shrink-0">
                    <span>Esports</span>
                    <!-- Placeholder Icon - Replace with actual Esports icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M5.166 2.023A.75.75 0 0 1 6 2.25h12a.75.75 0 0 1 .834.727l-.884 13.255a.75.75 0 0 1-.748.691H6.798a.75.75 0 0 1-.748-.691L5.166 2.977a.75.75 0 0 1 0-.954Zm11.21 5.227a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-1.499.046l-.001-.056a.75.75 0 0 1 .75-.75Zm-5.21 0a.75.75 0 0 1 .75.75v.01a.75.75 0 1 1-1.5.046l-.001-.056a.75.75 0 0 1 .75-.75Zm-4.458 8.999a.75.75 0 1 0 0 1.5h8.916a.75.75 0 1 0 0-1.5H7.708Z"
                            clip-rule="evenodd" />
                        <path
                            d="M3 16.79v.46a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-.46A4.5 4.5 0 0 0 18.75 15h-1.04a3 3 0 0 1-2.977 2.25H9.267a3 3 0 0 1-2.977-2.25H5.25A4.5 4.5 0 0 0 3 16.79Z" />
                    </svg>
                </a>
                <a href="#"
                    class="bg-twitch-pink text-white font-semibold py-2 px-4 rounded-lg flex items-center space-x-2 hover:bg-pink-700 whitespace-nowrap flex-shrink-0">
                    <span>Creative</span>
                    <!-- Placeholder Icon - Replace with actual Creative icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v1.222a.75.75 0 0 0 .5.707c1.28.36 2.56.555 3.25.555 1.954 0 3.823-.426 5.25-1.12V4.533ZM12.75 20.467a9.707 9.707 0 0 1 5.25 1.533 9.735 9.735 0 0 1 3.25-.555.75.75 0 0 1 .5-.707V19.51a.75.75 0 0 1-.5-.707c-1.28-.36-2.56-.555-3.25-.555-1.954 0-3.823.426-5.25 1.12v1.099Z" />
                        <path fill-rule="evenodd"
                            d="M12 3.75a8.25 8.25 0 1 0 0 16.5 8.25 8.25 0 0 0 0-16.5ZM9.69 7.72a.75.75 0 0 1 1.06 0l.053.053.053-.053a.75.75 0 0 1 1.06 0l3.75 3.75a.75.75 0 0 1 0 1.06l-3.75 3.75a.75.75 0 0 1-1.06 0l-.053-.053-.053.053a.75.75 0 0 1-1.06 0l-1.5-1.5a.75.75 0 1 1 1.06-1.06l.97.97 2.197-2.197a.75.75 0 0 0 0-1.06l-2.197-2.197-.97.97a.75.75 0 1 1-1.06-1.06l1.5-1.5Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <!-- ... Add more categories -->
            </div>

            <!-- Video Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-x-4 gap-y-8">
                <!-- Repeat Video Card Component (x12 for the example) -->
                <!-- Card 1 -->
                <div class="bg-twitch-bg-card rounded-lg overflow-hidden">
                    <div><img class="w-full h-auto object-cover aspect-video"
                            src="https://i.ytimg.com/vi/IsXvoYeVIaI/hq720.jpg?sqp=-oaymwEcCOgCEMoBSFXyq4qpAw4IARUAAIhCGAFwAcABBg==&rs=AOn4CLD_p76hY0G6xL7J1kP2h9kG9p9p_A"
                            alt="..."></div>
                    <div class="p-3 flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-1"><img class="w-9 h-9 rounded-full object-cover"
                                src="https://yt3.ggpht.com/ytc/AIdro_kY1Qo_3b7b7j7a_9aZ8w8e9Z9d_7f8g7h7g6h6=s48-c-k-c0x00ffffff-no-rj"
                                alt="Avatar"></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-white font-semibold text-sm leading-snug line-clamp-2 mb-1">The Beauty of
                                Existence - Heart Touching Nasheed</h3>
                            <p class="text-twitch-gray-light text-xs">19,210,251 views <span class="mx-1">·</span> Jul
                                1, 2016</p>
                        </div>
                        <div class="flex-shrink-0"><button
                                class="text-twitch-gray-light hover:text-white p-1 -mr-1"><svg
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                </svg></button></div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="bg-twitch-bg-card rounded-lg overflow-hidden">
                    <div><img class="w-full h-auto object-cover aspect-video"
                            src="https://i.ytimg.com/vi/IsXvoYeVIaI/hq720.jpg?sqp=-oaymwEcCOgCEMoBSFXyq4qpAw4IARUAAIhCGAFwAcABBg==&rs=AOn4CLD_p76hY0G6xL7J1kP2h9kG9p9p_A"
                            alt="..."></div>
                    <div class="p-3 flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-1"><img class="w-9 h-9 rounded-full object-cover"
                                src="https://yt3.ggpht.com/ytc/AIdro_kY1Qo_3b7b7j7a_9aZ8w8e9Z9d_7f8g7h7g6h6=s48-c-k-c0x00ffffff-no-rj"
                                alt="Avatar"></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-white font-semibold text-sm leading-snug line-clamp-2 mb-1">The Beauty of
                                Existence - Heart Touching Nasheed</h3>
                            <p class="text-twitch-gray-light text-xs">19,210,251 views <span class="mx-1">·</span> Jul
                                1, 2016</p>
                        </div>
                        <div class="flex-shrink-0"><button
                                class="text-twitch-gray-light hover:text-white p-1 -mr-1"><svg
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                </svg></button></div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="bg-twitch-bg-card rounded-lg overflow-hidden">
                    <div><img class="w-full h-auto object-cover aspect-video"
                            src="https://i.ytimg.com/vi/IsXvoYeVIaI/hq720.jpg?sqp=-oaymwEcCOgCEMoBSFXyq4qpAw4IARUAAIhCGAFwAcABBg==&rs=AOn4CLD_p76hY0G6xL7J1kP2h9kG9p9p_A"
                            alt="..."></div>
                    <div class="p-3 flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-1"><img class="w-9 h-9 rounded-full object-cover"
                                src="https://yt3.ggpht.com/ytc/AIdro_kY1Qo_3b7b7j7a_9aZ8w8e9Z9d_7f8g7h7g6h6=s48-c-k-c0x00ffffff-no-rj"
                                alt="Avatar"></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-white font-semibold text-sm leading-snug line-clamp-2 mb-1">The Beauty of
                                Existence - Heart Touching Nasheed</h3>
                            <p class="text-twitch-gray-light text-xs">19,210,251 views <span class="mx-1">·</span> Jul
                                1, 2016</p>
                        </div>
                        <div class="flex-shrink-0"><button
                                class="text-twitch-gray-light hover:text-white p-1 -mr-1"><svg
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                </svg></button></div>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="bg-twitch-bg-card rounded-lg overflow-hidden">
                    <div><img class="w-full h-auto object-cover aspect-video"
                            src="https://i.ytimg.com/vi/IsXvoYeVIaI/hq720.jpg?sqp=-oaymwEcCOgCEMoBSFXyq4qpAw4IARUAAIhCGAFwAcABBg==&rs=AOn4CLD_p76hY0G6xL7J1kP2h9kG9p9p_A"
                            alt="..."></div>
                    <div class="p-3 flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-1"><img class="w-9 h-9 rounded-full object-cover"
                                src="https://yt3.ggpht.com/ytc/AIdro_kY1Qo_3b7b7j7a_9aZ8w8e9Z9d_7f8g7h7g6h6=s48-c-k-c0x00ffffff-no-rj"
                                alt="Avatar"></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-white font-semibold text-sm leading-snug line-clamp-2 mb-1">The Beauty of
                                Existence - Heart Touching Nasheed</h3>
                            <p class="text-twitch-gray-light text-xs">19,210,251 views <span class="mx-1">·</span> Jul
                                1, 2016</p>
                        </div>
                        <div class="flex-shrink-0"><button
                                class="text-twitch-gray-light hover:text-white p-1 -mr-1"><svg
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                </svg></button></div>
                    </div>
                </div>
            </div>
        </main>

    </div>

</body>

</html>
