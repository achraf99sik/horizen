@extends('layouts.app')

@section('title', $video->title)

@section('content')
    <style>
        .player {
            width: 60%;
            aspect-ratio: unset;
            justify-self: center;
        }
    </style>
        <link rel="stylesheet" href="https://cdn.vidstack.io/player/theme.css" />
        <link rel="stylesheet" href="https://cdn.vidstack.io/player/video.css" />
            <div class="flex gap-6 mt-8">
                <div class="w-1/2 player">
                    <media-player title="{{ $video->title }}" src="{{ route("video.playlist", [$video->slug, 'index.m3u8']) }}">
                        <media-provider></media-provider>
                        <media-video-layout></media-video-layout>
                    </media-player>
                    <h1 class="font-bold text-xl">{{ $video->title }}</h1>
                    <div class="flex justify-between">
                        <div class="flex align-middle gap-4 items-center">
                            <div class="w-12 h-12 rounded-full bg-pink-300"></div>
                            <h3 class="text-xl">{{ $video->user->name }}</h3>
                            <button class="bg-pink-600 rounded-full p-2 font-semibold">Subscribe</button>
                        </div>
                        <div class="flex align-middle gap-4 items-center">
                            <div class="flex align-middle items-center">
                                <form class="inline">

                                    <button type="submit" class="bg-pink-600 rounded-l-full p-2 font-medium text-white like-button"
                                        data-video-id="1">
                                        Like
                                    </button>
                                </form>
                                <button class="bg-black rounded-r-full p-2 font-medium min-w-14">{{ $video->likes_count }}
                                    @if ($video->likes_count > 1)
                                        Likes
                                    @else
                                        Like
                                    @endif

                                </button>
                            </div>
                            <button class="bg-black rounded-full p-2 font-medium">Share</button>
                            <button class="bg-black rounded-full p-2 font-medium">Download</button>
                            <button class="bg-black rounded-full w-10 h-10 font-semibold">...</button>
                        </div>
                    </div>
                </div>
                <x-loading />
                <div id="related-videos"></div>
            </div>
            <div id="comments-list"></div>


@endsection
@push("scripts")
    <script src="https://cdn.vidstack.io/player" type="module"></script>
    <script>
        let videoId = {{ $video->id }};
        let videoPage = 1;
        let commentPage = 1;
        let loadingVideos = false;
        let loadingComments = false;

        function loadVideos() {
            if (loadingVideos) return;
            loadingVideos = true;
            document.getElementById('loading').style.display = 'block';
            fetch(`/api/videos/${videoId}/related?page=${videoPage}`)
                .then(res => res.json())
                .then(data => {
                    data.data.forEach(video => {
                        console.log(video);

                        document.getElementById('related-videos').innerHTML += `
                            <x-video-card slug="${video.slug}" title="${video.title}" thumbnail="${video.thumbnail}" views="${video.viewer_count}" date="${video.created_at}" />
                        `;
                    });
                    if (videoPage < data.total_pages) {
                        videoPage++;
                        loadingVideos = false;
                    }
                    document.getElementById('loading').style.display = 'none';
                });
        }

        function loadComments() {
            if (loadingComments) return;
            loadingComments = true;
            fetch(`/api/comments/${videoId}?page=${commentPage}`)
                .then(res => res.json())
                .then(data => {
                    data.data.forEach(comment => {
                        document.getElementById('comments-list').innerHTML += `
                            <div class="comment-card">${comment.content}</div>
                        `;
                    });
                    if (commentPage < data.total_pages) {
                        commentPage++;
                        loadingComments = false;
                    }
                });
        }

        window.addEventListener('scroll', () => {
            const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 500;
            if (nearBottom) {
                loadVideos();
                loadComments();
            }
        });

        loadVideos();
        loadComments();
        document.addEventListener('DOMContentLoaded', () => {
            const token = localStorage.getItem('token');
            const videoId = {{ $video->id }};

            if (!token || !videoId) return;

            fetch(`/api/like/${videoId}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.liked) {
                        const btn = document.querySelector('.like-button');
                        btn.innerText = 'Liked';
                        btn.classList.replace('bg-pink-600', 'bg-green-600');
                    }
                })
                .catch(err => console.error('Error fetching like status:', err));
        });
        document.querySelectorAll('.like-button').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                const videoId = {{ $video->id }};
                const token = localStorage.getItem('token');

                if (!token) {
                    alert("You must be logged in to like.");
                    return;
                }

                fetch('/api/like', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ video_id: videoId })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status) {
                            if (data.action === 'liked') {
                                this.innerText = 'Liked';
                                this.classList.replace('bg-pink-600', 'bg-green-600');
                            } else {
                                this.innerText = 'Like';
                                this.classList.replace('bg-green-600', 'bg-pink-600');
                            }
                        } else {
                            console.error('Validation failed:', data.errors);
                        }
                    })
                    .catch(err => {
                        console.error('Request failed:', err);
                    });
            });
        });
    </script>
@endpush
