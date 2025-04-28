<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function store(Request $request)
    {
        try {
            $validatedComment = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:50',
                ]
            );
            if ($validatedComment->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validatedComment->errors()
                ], 401);
            }

            $comment = Comment::create([
                'name' => $request->name,
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
    public function show(Comment $comment)
    {
        try {
            return response()->json([
                'status' => true,
                'message' => 'Comment Existes',
                'Comment' => $comment
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Comment updated successfully',
            'Comment' => $comment
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json([
            'status' => true,
            'message' => 'Comment deleted successfully'
        ], 204);
    }
}
