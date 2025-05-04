@extends('layouts.app')

@section('title', 'Sign Up')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-twitch-bg-dark">
        <div class="bg-twitch-bg-card p-8 rounded-2xl shadow-lg w-full max-w-md">
            <h1 class="text-3xl font-bold mb-6 text-center text-white">Create Account</h1>
            <form id="signupForm" class="space-y-4">
                <input type="text" name="name" placeholder="Username"
                    class="w-full p-3 focus:outline-none focus:ring-2 focus:ring-twitch-pink focus:border-twitch-pink bg-twitch-bg-hover text-white placeholder-twitch-gray-light rounded" required>
                <input type="email" name="email" placeholder="Email"
                    class="w-full p-3 focus:outline-none focus:ring-2 focus:ring-twitch-pink focus:border-twitch-pink bg-twitch-bg-hover text-white placeholder-twitch-gray-light rounded" required>
                <input type="password" name="password" placeholder="Password"
                    class="w-full p-3 focus:outline-none focus:ring-2 focus:ring-twitch-pink focus:border-twitch-pink bg-twitch-bg-hover text-white placeholder-twitch-gray-light rounded" required>

                <select name="role"
                    class="w-full p-3 bg-twitch-bg-hover text-white placeholder-twitch-gray-light rounded-lg border border-twitch-gray-dark focus:outline-none focus:ring-2 focus:ring-twitch-pink focus:border-twitch-pink transition ease-in-out duration-200"
                    required>
                    <option value="user" class="bg-twitch-bg-card">Regular User</option>
                    <option value="creator" class="bg-twitch-bg-card">Content Creator</option>
                </select>

                <button type="submit"
                    class="w-full bg-twitch-pink hover:bg-pink-700 p-3 rounded font-bold text-white">Sign Up</button>
            </form>
            <p id="signupMessage" class="text-center mt-4 text-sm text-green-400"></p>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.getElementById('signupForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            const response = await fetch('{{ route('singup') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            });

            const result = await response.json();
            const message = document.getElementById('signupMessage');

            if (response.ok) {
                localStorage.setItem('token', result.token);
                message.textContent = 'Signup successful!';
                this.reset();
            } else {
                message.textContent = result.errors ? JSON.stringify(result.errors) : result.message;
                message.classList.replace('text-green-400', 'text-red-400');
            }
        });
    </script>
@endpush
