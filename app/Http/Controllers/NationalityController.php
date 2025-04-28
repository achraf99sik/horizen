<?php

namespace App\Http\Controllers;


use App\Models\Nationality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NationalityController extends Controller
{
    /**
     * Display a listing of the nationalities.
     */
    public function index()
    {
        $perPage = 10;
        $nationalities = Nationality::paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Nationalities retrieved successfully',
            'data' => $nationalities->items(),
            'current_page' => $nationalities->currentPage(),
            'total_pages' => $nationalities->lastPage(),
            'total_items' => $nationalities->total(),
            'per_page' => $nationalities->perPage(),
        ], 200);
    }

    /**
     * Store a newly created nationality in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:nationalities,name',
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validated->errors()
                ], 422);
            }

            $nationality = Nationality::create([
                'name' => $request->name,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Nationality created successfully',
                'data' => $nationality
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
     * Display the specified nationality.
     */
    public function show(Nationality $nationality)
    {
        return response()->json([
            'status' => true,
            'message' => 'Nationality retrieved successfully',
            'data' => $nationality
        ], 200);
    }

    /**
     * Update the specified nationality in storage.
     */
    public function update(Request $request, Nationality $nationality)
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => 'sometimes|required|string|max:255|unique:nationalities,name,' . $nationality->id,
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validated->errors()
                ], 422);
            }

            $nationality->update([
                'name' => $request->name,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Nationality updated successfully',
                'data' => $nationality
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
     * Remove the specified nationality from storage.
     */
    public function destroy(Nationality $nationality)
    {
        $nationality->delete();

        return response()->json([
            'status' => true,
            'message' => 'Nationality deleted successfully',
        ], 200);
    }
}
