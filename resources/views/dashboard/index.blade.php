@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6">Welcome back, {{ $user->name }}!</h1>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 shadow rounded-lg">
                <h2 class="text-gray-600">Total Videos</h2>
                <p class="text-2xl font-bold">{{ $totalVideos }}</p>
            </div>
            <div class="bg-white p-6 shadow rounded-lg">
                <h2 class="text-gray-600">Total Comments</h2>
                <p class="text-2xl font-bold">{{ $totalComments }}</p>
            </div>
            <div class="bg-white p-6 shadow rounded-lg">
                <h2 class="text-gray-600">Total Views</h2>
                <p class="text-2xl font-bold">{{ number_format($totalViews) }}</p>
            </div>
        </div>

        {{-- Recent Videos --}}
        <div class="mb-10">
            <h2 class="text-xl font-semibold mb-3">Recent Videos</h2>
            @if($recentVideos->isEmpty())
                <p class="text-gray-500">No videos uploaded yet.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($recentVideos as $video)
                        <div class="bg-gray-100 p-3 rounded shadow-sm">
                            <img src="{{ Storage::url($video->thumbnail) }}" alt="Thumbnail"
                                class="w-full h-32 object-cover rounded mb-2">
                            <h3 class="font-semibold text-lg truncate">{{ $video->title }}</h3>
                            <p class="text-sm text-gray-500">Views: {{ $video->viewer_count }}</p>
                            <a href="/watch/{{ $video->slug }}" class="text-blue-500 text-sm hover:underline">View</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Recent Comments --}}
        <div>
            <h2 class="text-xl font-semibold mb-3">Recent Comments</h2>
            @if($recentComments->isEmpty())
                <p class="text-gray-500">No comments yet.</p>
            @else
                <ul class="space-y-3">
                    @foreach($recentComments as $comment)
                        <li class="bg-white p-4 shadow rounded">
                            <p>{{ $comment->text }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                On
                                <a href="/watch/{{ $video->slug }}" class="text-blue-600 hover:underline">
                                    {{ $comment->video->title }}
                                </a> • {{ $comment->created_at->diffForHumans() }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
