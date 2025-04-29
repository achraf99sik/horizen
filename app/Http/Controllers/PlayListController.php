<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Kyojin\JWT\Facades\JWT;
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
                'description' => 'required|string'
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validated->errors(),
                ], 422);
            }

            $token = (string) $request->bearerToken();
            $payload = JWT::decode($token);

            $playlist = Playlist::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => $payload['id'],
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Playlist created successfully',
                'data' => $playlist,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Playlist $playlist)
    {
        try {
            $validated = Validator::make($request->all(), [
                'title' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validated->errors()
                ], 422);
            }

            $playlist->update($request->only(['title', 'description']));

            return response()->json([
                'status' => true,
                'message' => 'Playlist updated successfully',
                'data' => $playlist
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Server error',
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
