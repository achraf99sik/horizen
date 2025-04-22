<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Kyojin\JWT\Facades\JWT;

final class AuthController extends Controller
{
    /**
     * Summary of store
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'errors' => $validated->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken();

        return response()->json([
            'user' => new Auth($user),
            'token' => $token,
        ], 201);
    }

    /**
     * Summary of login
     *
     * @return array{token: string, user: User|mixed|\Illuminate\Http\JsonResponse}
     */
    public function login(Request $request)
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
        if (! $user || ! Hash::check($request->password, $user->password)) {
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

    /**
     * Summary of show
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $token = $request->bearerToken();
        $payload = JWT::decode($token);

        return response()->json([
            'payload' => $payload,
        ], 200);
    }
}
