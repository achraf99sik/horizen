<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Kyojin\JWT\Facades\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 10;
        $likes = Like::paginate($perPage);

        return response()->json([
            'data' => $likes->items(),
            'current_page' => $likes->currentPage(),
            'total_pages' => $likes->lastPage(),
            'total_items' => $likes->total(),
            'per_page' => $likes->perPage(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedlike = Validator::make(
                $request->all(),
                [
                    'video_id' => 'required|exists:videos,id|integer'
                ]
            );

            if ($validatedlike->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validatedlike->errors()
                ], 401);
            }

            $token = (string) $request->bearerToken();
            $payload = JWT::decode($token);

            $userId = $payload['sub'];
            $videoId = $request->video_id;

            $existingLike = Like::where('user_id', $userId)
                ->where('video_id', $videoId)
                ->first();

            if ($existingLike) {
                $existingLike->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Like removed successfully',
                    'action' => 'unliked'
                ], 200);
            }

            $like = Like::create([
                'video_id' => $videoId,
                'user_id' => $userId,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Like created successfully',
                'like' => $like,
                'action' => 'liked'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */

    public function show($video_id, Request $request)
    {
        $token = (string) $request->bearerToken();
        $payload = JWT::decode($token);

        $user = $payload['sub'];

        $liked = Like::where('user_id', $user)
            ->where('video_id', $video_id)
            ->exists();

        return response()->json(['liked' => $liked]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        $like->delete();
        return response()->json([
            'status' => true,
            'message' => 'like deleted successfully'
        ], 204);
    }
}
