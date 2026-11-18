<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use Illuminate\Http\Request;

class AcademyController extends Controller
{
    // GET /api/academies
    public function index()
    {
        $academies = Academy::all();

        return response()->json($academies, 200);
    }

    // POST /api/academies
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $academy = Academy::create($validated);

        return response()->json($academy, 201);
    }

    // GET /api/academies/{academy}
    public function show(Academy $academy)
    {
        return response()->json($academy, 200);
    }

    // PUT/PATCH /api/academies/{academy}
    public function update(Request $request, Academy $academy)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $academy->update($validated);

        return response()->json($academy, 200);
    }

    // DELETE /api/academies/{academy}
    public function destroy(Academy $academy)
    {
        $academy->delete();

        return response()->json([
            'message' => 'Academia eliminada correctamente'
        ], 200);
    }
}