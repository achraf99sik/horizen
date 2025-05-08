<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $perPage = 10;
        $categories = Category::orderBy("created_at",'desc')->paginate($perPage);

        return response()->json([
            'data' => $categories->items(),
            'category_count' => number_format(Category::all()->count()),
            'current_page' => $categories->currentPage(),
            'total_pages' => $categories->lastPage(),
            'total_items' => $categories->total(),
            'per_page' => $categories->perPage(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedCategory = Validator::make(
                $request->all(),
                [
                'name' => 'required|string|max:50',
            ]);
            if ($validatedCategory->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validatedCategory->errors()
                ], 401);
            }

            $category = Category::create([
                'name' => $request->name,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'category Created Successfully',
                'category' => $category
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $category): View
    {
        $users = User::all()->mapWithKeys(function (User $user): array {
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
        $video = Video::with(["category", "user", "tags"])->where('category_id', $category)->withCount("viewer")->get();
        //////////////////////////////////////////////////////////////////////////////////////
        return view('home.home', compact('users', 'categories', 'video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $category->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'category updated successfully',
            'category' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return response()->json([
            'status' => true,
            'message' => 'category deleted successfully'
        ], 204);
    }
}
