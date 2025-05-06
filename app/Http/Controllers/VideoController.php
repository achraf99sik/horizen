<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use App\Models\Category;
use Illuminate\View\View;
use App\Jobs\ProcessVideo;
use Kyojin\JWT\Facades\JWT;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ProtoneMedia\LaravelFFMpeg\Http\DynamicHLSPlaylist;

class VideoController extends Controller
{
    private string $folder;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $categories = Category::all();
        return view('video.create', compact('users', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:categories,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'media' => 'required|file|mimes:mp4,avi,mpeg,mkv|max:2048000',
            'thumbnail' => 'required|image|mimes:jpg,gif,png,jpeg|max:8048',
            'description' => 'required|string|max:1000',
        ]);


        /** @var UploadedFile $original */
        $original = $request->file('media');

        $customFile = new FileUploadService(
            $original->getPathname(),
            $original->getClientOriginalName(),
            $original->getMimeType(),
            $original->getError(),
            false
        );
        $thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');

        $media = $customFile->store('raw', 'uploads');

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        ProcessVideo::dispatch($media['folder'], $media['file']);

        try {
            $token = (string) $request->bearerToken();
            $payload = JWT::decode($token);

            $video = Video::create([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'slug' => $media['folder'],
                'thumbnail' => $thumbnail,
                'description' => $request->description,
                'user_id' => $payload['sub'],
                'category_id' => $request->category_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Video created successfully',
                'video' => $video
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    /**
     * Summary of videoDetails
     * @param string $slug
     * @return View
     */
    public function videoDetails(string $slug, Request $request): View
    {
        $video = (object) Video::whereSlug($slug)->with(["category", "user", "tags", "likes", "comments"])->withCount("likes")->withCount("viewer")->first();
        return view("details", compact("video"));
    }
    public function fetchVideos(Request $request, $videoId)
    {
        $videos = Video::with(["category", "user", "tags"])
            ->withCount("viewer")
            ->whereNot("id", $videoId)
            ->paginate(6);

        return response()->json([
            'data' => $videos->map(function ($v) {
                return [
                    'title' => $v->title,
                    'slug' => $v->slug,
                    'thumbnail' => Storage::url($v->thumbnail),
                    'viewer_count' => number_format($v->viewer_count),
                    'created_at' => $v->created_at->format('M j, Y'),
                ];
            }),

            'current_page' => $videos->currentPage(),
            'total_pages' => $videos->lastPage(),
        ]);
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
