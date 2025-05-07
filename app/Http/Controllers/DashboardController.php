<?php

namespace App\Http\Controllers;

use App\Models\User;
use Kyojin\JWT\Facades\JWT;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->bearerToken();
        $payload = JWT::decode($token);
        $userId = $payload['sub'];

        $user = User::findOrFail($userId);

        $totalVideos = $user->videos()->count();
        $totalComments = $user->comments()->count();
        $totalViews = $user->videos()->withCount('viewer')->get()->sum('viewer_count');

        $recentVideos = $user->videos()->latest()->take(5)->get();
        $recentComments = $user->comments()->with('video')->latest()->take(5)->get();

        return view('dashboard.index', compact('user', 'totalVideos', 'totalComments', 'totalViews', 'recentVideos', 'recentComments'));

    }
}
