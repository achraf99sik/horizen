<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlaylistController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $playlists = Playlist::paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Playlists retrieved successfully',
            'data' => $playlists->items(),
            'current_page' => $playlists->currentPage(),
            'total_pages' => $playlists->lastPage(),
            'total_items' => $playlists->total(),
            'per_page' => $playlists->perPage(),
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'user_id' => 'required|exists:users,id|integer',
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validated->errors(),
                ], 422);
            }

            $playlist = Playlist::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => $request->user_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Playlist created successfully',
                'data' => $playlist,
            ], 201); // 201 = Created
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(Playlist $playlist)
    {
        try {
            return response()->json([
                'status' => true,
                'message' => 'Playlist retrieved successfully',
                'data' => $playlist,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(Playlist $playlist)
    {
        try {
            $playlist->delete();

            return response()->json([
                'status' => true,
                'message' => 'Playlist deleted successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
