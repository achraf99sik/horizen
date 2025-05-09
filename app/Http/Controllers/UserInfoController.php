<?php

namespace App\Http\Controllers;


use App\Models\UserInfo;
use Kyojin\JWT\Facades\JWT;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserInfoController extends Controller
{
    /**
     * Display a listing of the user infos.
     */
    public function index(): JsonResponse
    {
        $perPage = 10;
        $userInfos = UserInfo::paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'UserInfos retrieved successfully',
            'data' => $userInfos->items(),
            'current_page' => $userInfos->currentPage(),
            'total_pages' => $userInfos->lastPage(),
            'total_items' => $userInfos->total(),
            'per_page' => $userInfos->perPage(),
        ], 200);
    }

    /**
     * Store a newly created user info in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'video_id' => 'required|exists:videos,id',
        ]);

        $userId = auth()->id();

        $exists = DB::table('watch_histories')
            ->where('user_id', $userId)
            ->where('video_id', $request->video_id)
            ->exists();

        if (!$exists) {
            DB::table('watch_histories')->insert([
                'user_id' => $userId,
                'video_id' => $request->video_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return response()->json(['status' => true, 'message' => 'Watch history saved.']);
    }

    /**
     * Display the specified user info.
     */
    public function show(UserInfo $userInfo): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => 'UserInfo retrieved successfully',
            'data' => $userInfo
        ], 200);
    }

    /**
     * Update the specified user info in storage.
     */
    public function update(Request $request, UserInfo $userInfo): JsonResponse
    {
        try {
            $validated = Validator::make($request->all(), [
                'nationality_id' => 'sometimes|exists:nationalities,id|integer',
                'about' => 'sometimes|string',
                'date_birth' => 'sometimes|date',
                'sex' => 'sometimes|in:M,F',
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validated->errors()
                ], 422);
            }

            $userInfo->update($request->only(['nationality_id', 'about', 'date_birth', 'sex']));

            return response()->json([
                'status' => true,
                'message' => 'UserInfo updated successfully',
                'data' => $userInfo
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Server error',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
    public function storeOrUpdate(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'about' => 'required|string|max:1000',
                'date_birth' => 'required|date',
                'sex' => 'required|in:M,F',
                'nationality_id' => 'required|exists:nationalities,id',
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

            $userInfo = UserInfo::updateOrCreate(
                ['user_id' => $userId],
                [
                    'about' => $request->about,
                    'date_birth' => $request->date_birth,
                    'sex' => $request->sex,
                    'nationality_id' => $request->nationality_id
                ]
            );

            return response()->json([
                'status' => true,
                'message' => 'User info saved',
                'data' => $userInfo
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified user info from storage.
     */
    public function destroy(UserInfo $userInfo): JsonResponse
    {
        $userInfo->delete();

        return response()->json([
            'status' => true,
            'message' => 'UserInfo deleted successfully',
        ], 200);
    }
}
