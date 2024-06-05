<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with([
            'activity',
            'slot',
            'users' => function ($query) {
                $query->select('users.id', 'course_user.status');
            },
        ])->get();

        // Riformatta i dati per includere solo i campi necessari
        $result = $courses->map(function ($course) {
            return [
                'course_id' => $course->id,
                'activity' => $course->activity,
                'slot' => $course->slot,
                'users' => $course->users->map(function ($user) {
                    return [
                        'user_id' => $user->id,
                        'status' => $user->pivot->status,
                    ];
                }),
            ];
        });

        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $course = Course::with('activity', 'slot')->find($id);
        if (!$course) {
            return response(['status' => 'Not found'], 404); // torna sempre status 200
        }
        return ['data' => $course];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
