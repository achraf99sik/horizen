<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ProtoneMedia\LaravelFFMpeg\Http\DynamicHLSPlaylist;

class VideoController extends Controller
{
    private string $folder;
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Summary of videoDetails
     * @param string $slug
     * @return View
     */
    public function videoDetails(string $slug): View
    {
        $video = (object) [
            "title"=>"lharbaaaaa",
            "slug" => $slug
        ];
        return view("details", compact("video"));
    }
    /**
     * Summary of show
     * @param mixed $slug
     * @param mixed $filename
     * @return DynamicHLSPlaylist
     */
    public function show(string $slug, string $filename): DynamicHLSPlaylist
    {
        $this->folder = $slug;
        return FFMpeg::dynamicHLSPlaylist("uploads")
            ->fromDisk("uploads")
            ->open("{$this->folder}/videos/{$filename}")
            ->setKeyUrlResolver(function (string $key) {
                return route("video.key",["folder" => $this->folder, "key" => $key]);
            })
            ->setMediaUrlResolver(function (string $filename) {
                return route("video.file",["folder" => $this->folder, "file" => $filename]);
            })
            ->setPlaylistUrlResolver(function (string $filename) {
                return route("video.playlist",["folder" => $this->folder, "file" => $filename]);
            });
    }
    /**
     * Summary of getKey
     * @param string $folder
     * @param string $key
     * @return StreamedResponse
     */
    public function getKey(string $folder, string $key): StreamedResponse
    {
        return Storage::disk("uploads")->download($folder . "/secrets/" . $key);
    }
    /**
     * Summary of getFile
     * @param mixed $folder
     * @param mixed $file
     * @return StreamedResponse
     */
    public function getFile(string $folder, string $file): StreamedResponse
    {
        return Storage::disk("uploads")->download($folder . "/videos/" . $file);
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
