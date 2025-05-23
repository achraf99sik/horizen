<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Kyojin\JWT\Facades\JWT;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $perPage = 10;
        $comments = Comment::paginate($perPage);

        return response()->json([
            'data' => $comments->items(),
            'current_page' => $comments->currentPage(),
            'total_pages' => $comments->lastPage(),
            'total_items' => $comments->total(),
            'per_page' => $comments->perPage(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedComment = Validator::make(
                $request->all(),
                [
                    'text' => 'required|string|max:1024',
                    'video_id' => 'required|exists:videos,id|integer',
                    'comment_id' => 'nullable|exists:comments,id|integer'
                ]
            );
            if ($validatedComment->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validatedComment->errors()
                ], 422);
            }

            $token = (string) $request->bearerToken();
            $payload = JWT::decode($token);

            $comment = Comment::create([
                'text' => $request->text,
                'video_id' => $request->video_id,
                'comment_id' => $request->comment_id,
                'user_id' => $payload['sub']
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Comment Created Successfully',
                'Comment' => $comment
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
    public function show(Request $request, int $videoId): JsonResponse
    {
        $comments = Comment::where('video_id', $videoId)
            ->with(['comment','user'])
            ->paginate(5);
        $comments_count = Comment::where('video_id', $videoId)->count();

        return response()->json([
            'data' => $comments->items(),
            'comments_count' => $comments_count,
            'current_page' => $comments->currentPage(),
            'total_pages' => $comments->lastPage(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment): JsonResponse
    {
        $validatedComment = Validator::make(
            $request->all(),
            [
                'text' => 'string|max:1024',
                'comment_id' => 'exists:comments,id|integer',
            ]
        );
        if ($validatedComment->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validatedComment->errors()
            ], 401);
        }
        $comment->update([
            'text' => $request->text,
            'comment_id' => $request->comment_id,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Comment updated successfully',
            'Comment' => $comment
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();
        return response()->json([
            'status' => true,
            'message' => 'Comment deleted successfully'
        ], 204);
    }
}
