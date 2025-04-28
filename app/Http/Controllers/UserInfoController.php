<?php

namespace App\Http\Controllers;


use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserInfoController extends Controller
{
    /**
     * Display a listing of the user infos.
     */
    public function index()
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
    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id|integer',
                'nationality_id' => 'required|exists:nationalities,id|integer',
                'about' => 'required|string',
                'date_birth' => 'required|date',
                'sex' => 'required|in:M,F',
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validated->errors()
                ], 422);
            }

            $userInfo = UserInfo::create([
                'user_id' => $request->user_id,
                'nationality_id' => $request->nationality_id,
                'about' => $request->about,
                'date_birth' => $request->date_birth,
                'sex' => $request->sex,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'UserInfo created successfully',
                'data' => $userInfo
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Server error',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified user info.
     */
    public function show(UserInfo $userInfo)
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
    public function update(Request $request, UserInfo $userInfo)
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

    /**
     * Remove the specified user info from storage.
     */
    public function destroy(UserInfo $userInfo)
    {
        $userInfo->delete();

        return response()->json([
            'status' => true,
            'message' => 'UserInfo deleted successfully',
        ], 200);
    }
}
