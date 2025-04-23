<link rel="stylesheet" href="https://cdn.vidstack.io/player/theme.css" />
<link rel="stylesheet" href="https://cdn.vidstack.io/player/video.css" />
<div>
    <media-player title="{{ $video->title }}" src="{{ route("video.playlist", [$video->slug, 'index.m3u8']) }}">
        <media-provider></media-provider>
        <media-video-layout></media-video-layout>
    </media-player>
</div>
<script src="https://cdn.vidstack.io/player" type="module"></script>
