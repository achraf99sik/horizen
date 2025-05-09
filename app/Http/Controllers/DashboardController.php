<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Kyojin\JWT\Facades\JWT;
use Illuminate\Http\Request;
use Kyojin\JWT\Services\JWTService;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $token = explode(';', $request->header("cookie"))[1];
        $token = preg_replace('/^ token=/', '', $token);
        $userId = JWT::decode($token)['sub'];

        $user = User::findOrFail($userId);

        $totalVideos = $user->videos()->count();
        $totalComments = $user->comments()->count();
        $totalViews = $user->videos()->withCount('viewer')->get()->sum('viewer_count');

        $recentVideos = $user->videos()->withCount('viewer')->latest()->take(5)->get();
        $recentComments = $user->comments()->with('video')->latest()->take(5)->get();

        return view('dashboard.index', compact('user', 'totalVideos', 'totalComments', 'totalViews', 'recentVideos', 'recentComments'));

    }
}
