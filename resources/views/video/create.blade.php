@extends('layouts.app')

@section('title', 'Upload')

@section('content')
    <!-- Wrap in a container simulating the modal -->
    <div class="bg-twitch-bg-card p-6 sm:p-8 rounded-lg shadow-xl max-w-4xl mx-auto text-gray-300">

        <!-- Modal Header (Simulated) -->
        <div class="flex justify-between items-center pb-4 mb-6 border-b border-gray-700">
            <h2 class="text-xl font-semibold text-white">Video Details</h2>
            <!-- Placeholder for close button -->
            <button type="button" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="{{ route('videos.store') }}" method="POST" id="uploadForm" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Left Column -->
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <label for="title" class="flex items-center text-sm font-medium text-gray-400 mb-1">
                            Title (required)
                            <!-- Placeholder for help icon -->
                            <svg class="w-4 h-4 ml-1 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </label>
                        <input type="text" name="title" id="title" required
                            class="block w-full rounded-md p-2.5 bg-twitch-bg-hover text-white placeholder-twitch-gray-light focus:outline-none focus:ring-2 focus:ring-twitch-purple shadow-sm">
                    </div>

                    <!-- Subtitle Field (Not in target image, added here) -->
                    <div>
                        <label for="subtitle" class="block text-sm font-medium text-gray-400 mb-1">Subtitle</label>
                        <textarea name="subtitle" id="subtitle" required rows="2"
                            class="block w-full rounded-md p-2.5 bg-twitch-bg-hover text-white placeholder-twitch-gray-light focus:outline-none focus:ring-2 focus:ring-twitch-purple shadow-sm"></textarea>
                    </div>


                    <div>
                        <label for="description" class="flex items-center text-sm font-medium text-gray-400 mb-1">
                            Description
                            <!-- Placeholder for help icon -->
                            <svg class="w-4 h-4 ml-1 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </label>
                        <textarea name="description" id="description" required rows="4"
                            placeholder="Tell viewers about your video (type @ to mention a channel)"
                            class="block w-full rounded-md p-2.5 bg-twitch-bg-hover text-white placeholder-twitch-gray-light focus:outline-none focus:ring-2 focus:ring-twitch-purple shadow-sm"></textarea>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-400 mb-1">Thumbnail</span>
                        <p class="text-xs text-gray-500 mb-2">Set a thumbnail that stands out and draws viewers' attention.
                            <a href="#" class="text-yellow-500 hover:underline">Learn more</a>
                        </p>
                        <!-- Visually hidden input -->
                        <input type="file" accept=".jpg,.gif,.png,.jpeg" name="thumbnail" id="thumbnail" required
                            class="hidden"
                            onchange="document.getElementById('thumbnail-preview-text').textContent = this.files[0] ? this.files[0].name : 'Upload file';">

                        <!-- Styled label acting as upload button -->
                        <label for="thumbnail"
                            class="cursor-pointer flex flex-col items-center justify-center w-full h-32 border-2 border-twitch-purple border-dashed rounded-lg bg-twitch-bg-card hover:bg-twitch-bg-hover transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-gray-400">
                                <svg class="w-10 h-10 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p class="mb-2 text-sm" id="thumbnail-preview-text">Upload file</p>
                                <p class="text-xs">JPG, PNG, GIF, JPEG</p>
                            </div>
                        </label>
                    </div>

                    <!-- Category Select (Not in target image details, added here) -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-400 mb-1">Category</label>
                        <select name="category_id" id="category_id" required
                            class="p-3 bg-twitch-bg-hover text-white placeholder-twitch-gray-light rounded-lg border border-twitch-gray-dark focus:outline-none focus:ring-2 focus:ring-twitch-purple focus:border-twitch-purple transition ease-in-out duration-200"
                            style="">
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <!-- Right Column (Video Preview Placeholder) -->
                <div class="md:col-span-1 space-y-4">
                    <!-- Media File Input (Required by form, styled simply here) -->
                    <div>
                        <label for="media" class="block text-sm font-medium text-gray-400 mb-1">Video File
                            (required)</label>
                        <input type="file" accept=".mp4,.avi,.mpeg,.mkv" name="media" id="media" required
                            class="block w-full text-sm bg-twitch-bg-hover text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-twitch-bg-card focus:ring-purple-500 rounded-md border border-gray-700 p-1.5">
                        <p class="mt-1 text-xs text-gray-500">MP4, AVI, MPEG, MKV</p>
                    </div>

                    <!-- Placeholder mimicking the video preview -->
                    <div id="video-preview-container"
                        class="bg-black aspect-video rounded-md flex items-center justify-center border border-gray-700 overflow-hidden">
                        <video id="video-preview" class="w-full h-full object-contain hidden" controls></video>
                        <span id="video-placeholder" class="text-gray-600">Video Preview Area</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-400">Filename</span>
                        <p class="text-sm text-gray-500 truncate" id="video-filename-preview">No video selected</p>
                        <!-- Add JS to update this when #media changes -->

                    </div>
                </div>

            </div>

            <!-- Modal Footer (Simulated) -->
            <div class="flex justify-end pt-6 mt-6 border-t border-gray-700">
                <button type="submit"
                    class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-6 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-twitch-bg-card focus:ring-pink-500">
                    Done <!-- Changed text from "Create Video" -->
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('media')?.addEventListener('change', function () {
            const filenamePreview = document.getElementById('video-filename-preview');
            const videoPreview = document.getElementById('video-preview');
            const placeholder = document.getElementById('video-placeholder');

            if (this.files && this.files[0]) {
                const file = this.files[0];
                filenamePreview.textContent = file.name;

                const fileURL = URL.createObjectURL(file);
                videoPreview.src = fileURL;
                videoPreview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                filenamePreview.textContent = 'No video selected';
                videoPreview.src = '';
                videoPreview.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        });
        document.getElementById('uploadForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const token = localStorage.getItem('token');

            if (!token) {
                alert("You must be logged in to upload.");
                return;
            }

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    alert("Upload successful!");
                } else {
                    console.error(result);
                    alert("Upload failed: " + (result.message || 'Unknown error'));
                }

            } catch (error) {
                console.error(error);
                alert("An error occurred while uploading.");
            }
        });
    </script>
@endpush
