<?php

namespace App\Http\Controllers;


use Kyojin\JWT\Facades\JWT;
use App\Models\WatchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WatchHistoryController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $watchHistories = WatchHistory::paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Watch histories retrieved successfully',
            'data' => $watchHistories->items(),
            'current_page' => $watchHistories->currentPage(),
            'total_pages' => $watchHistories->lastPage(),
            'total_items' => $watchHistories->total(),
            'per_page' => $watchHistories->perPage(),
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'video_id' => 'required|exists:videos,id',
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validated->errors()
                ], 422);
            }

            $token = (string) $request->bearerToken();
            $payload = JWT::decode($token);

            $watchHistory = WatchHistory::create([
                'user_id' => $payload['id'],
                'video_id' => $request->video_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Watch history created successfully',
                'data' => $watchHistory
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Server error',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(WatchHistory $watchHistory)
    {
        return response()->json([
            'status' => true,
            'message' => 'Watch history retrieved successfully',
            'data' => $watchHistory
        ], 200);
    }

    public function update(Request $request, WatchHistory $watchHistory)
    {
        try {
            $validated = Validator::make($request->all(), [
                'video_id' => 'sometimes|exists:videos,id',
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validated->errors()
                ], 422);
            }

            $watchHistory->update($request->only(['video_id']));

            return response()->json([
                'status' => true,
                'message' => 'Watch history updated successfully',
                'data' => $watchHistory
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Server error',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(WatchHistory $watchHistory)
    {
        $watchHistory->delete();

        return response()->json([
            'status' => true,
            'message' => 'Watch history deleted successfully',
        ], 200);
    }
}
