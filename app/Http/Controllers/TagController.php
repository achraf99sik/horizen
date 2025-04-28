<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $tags = Tag::paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Tags retrieved successfully',
            'data' => $tags->items(),
            'current_page' => $tags->currentPage(),
            'total_pages' => $tags->lastPage(),
            'total_items' => $tags->total(),
            'per_page' => $tags->perPage(),
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:tags,name',
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validated->errors()
                ], 422);
            }

            $tag = Tag::create([
                'name' => $request->name,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Tag created successfully',
                'data' => $tag
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Server error',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(Tag $tag)
    {
        return response()->json([
            'status' => true,
            'message' => 'Tag retrieved successfully',
            'data' => $tag
        ], 200);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->json([
            'status' => true,
            'message' => 'Tag deleted successfully',
        ], 200);
    }
}

