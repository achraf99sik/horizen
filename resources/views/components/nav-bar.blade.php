<nav class="bg-navbar-bg text-white flex items-center justify-between px-4 py-2">
    <div class="flex items-center space-x-4">
        <a href="/" class="flex-shrink-0">
            <img width="50px" src="{{ asset('Logo.png') }}" alt="Logo">
        </a>

        <a href="/following" class="font-semibold text-gray-300 hover:text-white" id="nav-following">Following</a>
        <a href="/" class="font-semibold text-gray-300 hover:text-white" id="nav-browse">Browse</a>

        <button class="text-gray-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
            </svg>
        </button>
    </div>

    <div class="flex-1 flex justify-center px-6 lg:px-10">
        <form action="/search" method="GET" class="relative w-full max-w-xs lg:max-w-sm">
            <input type="text" name="q" placeholder="Search"
                class="bg-search-bg border border-search-border text-gray-200 placeholder-gray-400 rounded-md py-1.5 px-4 pl-10 block w-full focus:outline-none focus:ring-1 focus:ring-brand-pink focus:border-brand-pink"/>
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </form>
    </div>

    <div id="navbar-auth" class="flex items-center space-x-4"></div>
</nav>

<script>
    document.cookie = `token=${localStorage.getItem('token')}; path=/; SameSite=None; Secure;`;
    document.addEventListener('DOMContentLoaded', () => {
        const authSection = document.getElementById('navbar-auth');

        fetch('/api/me', {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
        })
            .then(res => res.ok ? res.json() : Promise.reject('Unauthorized'))
            .then(user => {
                if (user.role=="creator") {
                    authSection.innerHTML = `
                    <a href="/upload" class="border border-brand-pink px-4 py-1.5 text-sm rounded-md hover:bg-pink-600 hover:text-white transition">
                        Upload
                    </a>`;
                }
                authSection.innerHTML += `
                    <button class="relative text-gray-400 hover:text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.017 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                        </svg>
                        <span class="absolute -top-2 -right-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-brand-pink rounded-full">
                            0
                        </span>
                    </button>
                    <a href="/messages" class="text-gray-400 hover:text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                    </a>
                    <form method="post" action="/dashboard">
                        <input type="hidden" name="token"/>
                        @csrf
                        <button id="view-dashboard" type="submit">
                            <img src="${user.avatar_url || '/default-avatar.png'}" class="w-8 h-8 rounded-full border-2 border-brand-pink" alt="${user.name}">
                        </button>
                    </form>
                `;

                document.getElementById('view-dashboard').addEventListener('submit', function (e) {
                    e.preventDefault();

                    const token = localStorage.getItem('token');
                    if (!token) {
                        alert("You must be logged in to view the dashboard.");
                        return;
                    }

                    fetch('/dashboard', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json',
                        },
                        body: new FormData(this)
                    })
                    .then(res => res.ok ? res.text() : Promise.reject('Failed to load dashboard'))
                    .then(html => {

                        document.open();
                        document.write(html);
                        document.close();
                    })
                    .catch(err => {
                        console.error('Request failed:', err);
                        alert('Failed to load dashboard');
                    });
                });

            })
            .catch(() => {
                authSection.innerHTML = `
            <a href="/login" class="bg-brand-pink px-4 py-1.5 text-sm rounded-md hover:bg-pink-600 transition">
                Login
            </a>
            <a href="/signup" class="border border-brand-pink px-4 py-1.5 text-sm rounded-md hover:bg-pink-600 hover:text-white transition">
                Sign Up
            </a>
        `;
            });
    });

</script>

