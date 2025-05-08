<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::all()->mapWithKeys(function ($user) {
            return [
                $user->id => (object) [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar_url' => $user->avatar ? Storage::url($user->avatar) : null,
                    'role' => $user->role,
                ],
            ];
        })->toArray();

        $users = (object) $users;
        
        $categories = Category::all();
        ////////////////////// THIS IS THE HOME PAGE DATA ////////////////////////////////////////
        $video = Video::with(["category", "user", "tags"])->withCount("viewer")->get();
        //////////////////////////////////////////////////////////////////////////////////////
        return view('home.home', compact('users', 'categories', 'video'));
    }
}
