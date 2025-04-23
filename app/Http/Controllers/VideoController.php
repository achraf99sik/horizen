<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $this->folder = $slug;
        return FFMpeg::dynamicHLSPlaylist("uploads")
            ->fromDisk("uploads")
            ->open("{$this->folder}/index.m3u8")
            ->setKeyUrlResolver(function ($key) {
                return route("video.key",["folder" => $this->folder, "key" => $key]);
            })
            ->setMediaUrlResolver(function ($filename) {
                return route("video.file",["folder" => $this->folder, "file" => $filename]);
            })
            ->setPlaylistUrlResolver(function ($filename) {
                return route("video.playlist",["folder" => $this->folder, "file" => $filename]);
            });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
