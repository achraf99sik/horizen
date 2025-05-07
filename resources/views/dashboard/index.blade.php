@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6">Welcome back, {{ $user->name }}!</h1>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            <div class="bg-gradient-to-r from-lime-400 to-green-600 text-white p-6 rounded-xl shadow-lg transform transition duration-300 hover:shadow-2xl hover:shadow-green-500/50 dark:hover:shadow-lime-800/80">
                <h2 class="text-lg font-semibold">Total Videos</h2>
                <p class="text-3xl font-bold mt-2">{{ $totalVideos }}</p>

            </div>
            <div class="bg-gradient-to-r from-red-400 to-orange-600 text-white p-6 rounded-xl shadow-lg transform transition duration-300 hover:shadow-2xl hover:shadow-pink-500/50 dark:hover:shadow-orange-800/80">
                <h2 class="text-lg font-semibold">Total Comments</h2>
                <p class="text-3xl font-bold mt-2">{{ $totalComments }}</p>
            </div>
            <div class="bg-gradient-to-r from-blue-400 to-purple-600 text-white p-6 rounded-xl shadow-lg transform transition duration-300  hover:shadow-2xl hover:shadow-purple-500/50 dark:hover:shadow-blue-800/80">
                <h2 class="text-lg font-semibold">Total Views</h2>
                <p class="text-3xl font-bold mt-2">{{ number_format($totalViews) }}</p>
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
                        <x-video-card slug="{{ $video->slug }}" title="{{ $video->title }}" thumbnail="{{ Storage::url($video->thumbnail) }}" views="{{ $video->viewer_count }}"
                            date="{{ $video->created_at->format('M j, Y') }}" />
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
