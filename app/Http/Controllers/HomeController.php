<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::all();
        $categories = Category::all();
        ////////////////////// THIS IS THE HOME PAGE DATA ////////////////////////////////////////
        $video = Video::with(["category", "user", "tags", "comments"])->withCount("viewer")->get();
        //////////////////////////////////////////////////////////////////////////////////////
        return view('home.home', compact('users', 'categories', 'video'));
    }
}
