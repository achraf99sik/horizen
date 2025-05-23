<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Kyojin\JWT\Facades\JWT;
use App\Http\Resources\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

final class AuthController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $token = (string) $request->bearerToken();
        $payload = JWT::decode($token);
        $user_id = $payload['sub'];
        $user = User::where('id', $user_id)->first();

        return response()->json([
            'name' => $user->name ?? null,
            'email' => $user->email ?? null,
            'avatar_url' => Storage::url($user->avatar) ?? null,
            'role' => $user->role ?? null,
        ]);
    }

    /**
     * Summary of store
     */
    public function store(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,creator,admin',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:12048',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'errors' => $validated->errors(),
            ], 422);
        }

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $password = is_string($request->password) ? (string) $request->password : '';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => $request->role,
            'avatar' => $avatarPath,
        ]);

        $token = $user->createToken();

        return response()->json([
            'user' => new Auth($user),
            'token' => $token,
        ], 201);
    }

    /**
     * Summary of login
     */
    public function login(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'errors' => $validated->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        $password = is_string($request->password) ? (string) $request->password : '';
        if (! $user || ! Hash::check($password, $user->password)) {
            return response()->json([
                'message' => 'Email or password is incorrect',
            ], 401);
        }

        $token = $user->createToken();

        return response()->json([
            'user' => new Auth($user),
            'token' => $token,
        ], 201);
    }
}
