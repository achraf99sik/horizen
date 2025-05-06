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
            <div class="flex justify-around gap-6 mt-8">
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
                    <h2 class="text-xl mt-2 font-bold mb-4">Leave a Comment</h2>
                    <form id="comment-form" class="mb-6">
                        @csrf
                        <input type="hidden" id="comment_video_id" value="{{ $video->id }}">
                        <input type="hidden" id="parent_comment_id" value="">
                        <textarea id="comment_text" class="w-full p-2 bg-twitch-bg-header focus:outline-none focus:ring-2 focus:ring-twitch-purple rounded" rows="4"
                            placeholder="Write your comment..."></textarea>
                        <button type="submit" class="mt-2 px-4 py-2 bg-twitch-pink text-white rounded-full">Post</button>
                    </form>

                    <!-- For reply indicator -->
                    <div id="replying-to" class="text-sm text-gray-600 mb-2 hidden">
                        Replying to a comment... <button onclick="cancelReply()" class="text-red-500 underline">Cancel</button>
                    </div>
                    <h2 class="text-xl font-bold mb-4">Comments (<span id="comments_count"></span>)</h2>
                    <div id="comments-list" class="space-y-4"></div>
                    <x-loading class="self-center" loadingId="comments-loading"/>
                </div>
                <x-loading />
                <div id="related-videos"></div>
            </div>


@endsection
@push("scripts")
    <script src="https://cdn.vidstack.io/player" type="module"></script>
    <script>
        let videoId = {{ $video->id }};
        let videoPage = 1;
        let commentPage = 1;
        let loadingVideos = false;
        let loadingComments = false;
        let commentEndReached = false;

        function loadVideos() {
            if (loadingVideos) return;
            loadingVideos = true;
            document.getElementById('loading').style.display = 'block';
            fetch(`/api/videos/${videoId}/related?page=${videoPage}`)
                .then(res => res.json())
                .then(data => {
                    data.data.forEach(video => {
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

        function formatComment(comment, depth = 0) {
            let marginLeft = depth * 20;
            let html = `
                <div class="bg-twitch-bg-header p-3 rounded" style="margin-left: ${marginLeft}px">
                    <p class="text-sm text-gray-300 font-semibold">${comment.user.name}</p>
                    <p class="text-base text-white">${comment.text}</p>
                    <p class="text-xs text-gray-400">${new Date(comment.created_at).toLocaleDateString()}</p>
                </div>
            `;

            if (comment.replies && comment.replies.length > 0) {
                comment.replies.forEach(reply => {
                    html += formatComment(reply, depth + 1);
                });
            }

            return html;
        }

        function loadComments(reset = false) {
            if (loadingComments || (commentEndReached && !reset)) return;

            loadingComments = true;
            document.getElementById('comments-loading').style.display = 'block';

            if (reset) {
                commentPage = 1;
                commentEndReached = false;
                document.getElementById('comments-list').innerHTML = '';
            }

            fetch(`/api/comments/${videoId}?page=${commentPage}`)
                .then(res => res.json())
                .then(data => {
                    if (data.data.length === 0 && !reset) {
                        commentEndReached = true;
                    }

                    document.getElementById("comments_count").innerText = `${data.comments_count}`;

                    data.data.forEach(comment => {
                        document.getElementById('comments-list').innerHTML += formatComment(comment);
                    });

                    if (commentPage < data.total_pages) {
                        commentPage++;
                        loadingComments = false;
                    }

                    document.getElementById('comments-loading').style.display = 'none';
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
        document.getElementById('comment-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const token = localStorage.getItem('token');
            if (!token) {
                alert("You must be logged in to comment.");
                return;
            }

            const text = document.getElementById('comment_text').value.trim();
            const videoId = {{ $video->id }};
            const parentId = document.getElementById('parent_comment_id').value || null;

            if (!text) return alert("Comment cannot be empty.");

            fetch('/api/comments', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    text: text,
                    video_id: videoId,
                    comment_id: parentId
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status) {
                        document.getElementById('comment_text').value = '';
                        document.getElementById('parent_comment_id').value = '';
                        document.getElementById('replying-to').classList.add('hidden');

                        loadComments(true);

                    } else {
                        console.error('Validation failed:', data.errors);
                    }
                })
                .catch(err => console.error('Request failed:', err));
        });
    </script>
@endpush
