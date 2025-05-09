@extends('layouts.app')

@section('title', 'Sign Up')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-twitch-bg-dark">
        <div class="bg-twitch-bg-card p-8 rounded-2xl shadow-lg w-full max-w-md">
            <h1 class="text-3xl font-bold mb-6 text-center text-white">Create Account</h1>
            <form id="signupForm" class="space-y-4" enctype="multipart/form-data">
                <div class="mt-2 flex justify-center content-center">
                    <img id="avatarPreview" src="" alt="Preview"
                        class="w-24 h-24 rounded-full object-cover hidden border border-gray-700" />
                </div>
                <div>
                    <label for="avatar" class="block text-sm font-medium text-gray-400 mb-1">
                        Avatar Image (optional)
                    </label>
                    <input
                        type="file"
                        accept=".jpg,.jpeg,.png,.webp"
                        name="avatar"
                        id="avatar"
                        class="block w-full text-sm bg-twitch-bg-hover text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-twitch-bg-card focus:ring-purple-500 rounded-md border border-gray-700 p-1.5"
                    >
                    <p class="mt-1 text-xs text-gray-500">JPG, PNG, WEBP — up to 2MB</p>
                </div>

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
        document.getElementById('avatar').addEventListener('change', function (e) {
                const file = e.target.files[0];
                const preview = document.getElementById('avatarPreview');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        preview.src = event.target.result;
                        preview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '';
                    preview.classList.add('hidden');
                }
            });
        document.getElementById('signupForm').addEventListener('submit', async function (e) {
                e.preventDefault();
                const formData = new FormData(this);

                const response = await fetch('{{ route('singup') }}', {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();
                const message = document.getElementById('signupMessage');

                if (response.ok) {
                    localStorage.setItem('token', result.token);
                    message.textContent = 'Signup successful!';
                    this.reset();
                    message.classList.replace('text-red-400', 'text-green-400');
                } else {
                    message.textContent = result.errors ? JSON.stringify(result.errors) : result.message;
                    message.classList.replace('text-green-400', 'text-red-400');
                }
            });
    </script>
@endpush
