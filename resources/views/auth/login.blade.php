@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-twitch-bg-dark px-4">
        <div class="bg-twitch-bg-card p-8 rounded-2xl shadow-lg w-full max-w-md text-white">
            <h1 class="text-3xl font-bold mb-6 text-center text-twitch-gray-light">Login</h1>

            <form id="loginForm" class="space-y-4">
                <input type="email" name="email" placeholder="Email"
                    class="w-full p-3 rounded-lg bg-twitch-bg-hover text-white placeholder-twitch-gray-light focus:outline-none focus:ring-2 focus:ring-twitch-purple"
                    required>
                <input type="password" name="password" placeholder="Password"
                    class="w-full p-3 rounded-lg bg-twitch-bg-hover text-white placeholder-twitch-gray-light focus:outline-none focus:ring-2 focus:ring-twitch-purple"
                    required>
                <button type="submit"
                    class="w-full bg-twitch-purple hover:bg-purple-700 p-3 rounded-lg font-bold transition duration-200">
                    Login
                </button>
            </form>

            <p id="loginMessage" class="text-center mt-4 text-sm text-green-400"></p>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.getElementById('loginForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            const response = await fetch('{{ route('login') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            });

            const result = await response.json();
            const message = document.getElementById('loginMessage');

            if (response.ok) {
                localStorage.setItem('token', result.token);
                message.textContent = 'Login successful!';
                this.reset();
            } else {
                message.textContent = result.errors ? JSON.stringify(result.errors) : result.message;
                message.classList.replace('text-green-400', 'text-red-400');
            }
        });
    </script>
@endpush
