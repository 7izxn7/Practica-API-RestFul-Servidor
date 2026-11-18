<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Student;

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

    public function students(Course $course)
    {
        $students = $course->students;

        return response()->json($students, 200);
    }

    public function enroll(Course $course, Student $student, Request $request)
    {
        // Comprobar que el usuario es propietario de la academia
        if ($course->academy->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'No tienes permiso para matricular estudiantes en este curso'
            ], 403);
        }

        // Matricular al estudiante
        $course->students()->attach($student->id, [
            'enrolled_at' => now()
        ]);

        return response()->json([
            'message' => 'Estudiante matriculado correctamente'
        ], 200);
    }

    public function unenroll(Course $course, Student $student, Request $request)
    {
        // Comprobar que el usuario es propietario de la academia
        if ($course->academy->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'No tienes permiso para desmatricular estudiantes de este curso'
            ], 403);
        }

        // Eliminar la matrícula
        $course->students()->detach($student->id);

        return response()->json([
            'message' => 'Estudiante desmatriculado correctamente'
        ], 200);
    }
}