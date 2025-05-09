<?php

namespace App\Http\Controllers;


use Kyojin\JWT\Facades\JWT;
use App\Models\WatchHistory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class WatchHistoryController extends Controller
{
    public function index(): JsonResponse
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

    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'video_id' => 'required|exists:videos,id|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $token = $request->bearerToken();
            $payload = JWT::decode($token);

            $userId = $payload['sub'];
            $videoId = $request->video_id;

            $existing = WatchHistory::where('user_id', $userId)
                                    ->where('video_id', $videoId)
                                    ->first();

            if (!$existing) {
                WatchHistory::create([
                    'user_id' => $userId,
                    'video_id' => $videoId,
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Watch history recorded.'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show(WatchHistory $watchHistory): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => 'Watch history retrieved successfully',
            'data' => $watchHistory
        ], 200);
    }

    public function update(Request $request, WatchHistory $watchHistory): JsonResponse
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

    public function destroy(WatchHistory $watchHistory): JsonResponse
    {
        $watchHistory->delete();

        return response()->json([
            'status' => true,
            'message' => 'Watch history deleted successfully',
        ], 200);
    }
}
