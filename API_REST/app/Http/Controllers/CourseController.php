<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // GET /api/courses
    public function index()
    {
        $courses = Course::all();

        return response()->json($courses, 200);
    }

    // POST /api/courses
    public function store(Request $request)
    {
        $validated = $request->validate([
            'academy_id' => 'required|exists:academies,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'capacity' => 'nullable|integer|min:1',
        ]);

        $course = Course::create($validated);

        return response()->json($course, 201);
    }

    // GET /api/courses/{course}
    public function show(Course $course)
    {
        return response()->json($course, 200);
    }

    // PUT/PATCH /api/courses/{course}
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'capacity' => 'nullable|integer|min:1',
        ]);

        $course->update($validated);

        return response()->json($course, 200);
    }

    // DELETE /api/courses/{course}
    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'message' => 'Curso eliminado correctamente'
        ], 200);
    }
}