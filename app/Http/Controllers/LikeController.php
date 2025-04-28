<?php

namespace App\Http\Controllers;

use App\Models\Like;
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
                    'video_id' => 'required|exists:videos,id|integer',
                    'user_id' => 'required|exists:users,id|integer',
                ]
            );
            if ($validatedlike->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validatedlike->errors()
                ], 401);
            }

            $like = Like::create([
                'video_id' => $request->video_id,
                'user_id' => $request->user_id,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'like Created Successfully',
                'like' => $like
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
    public function show(Like $like)
    {
        try {
            return response()->json([
                'status' => true,
                'message' => 'like Existes',
                'like' => $like
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
