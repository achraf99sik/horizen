<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function store(Request $request)
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
    public function show(Category $category)
    {
        try {
            return response()->json([
                'status' => true,
                'message' => 'category Existes',
                'category' => $category
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
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
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'status' => true,
            'message' => 'category deleted successfully'
        ], 204);
    }
}
