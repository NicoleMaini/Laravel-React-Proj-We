<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        if (Auth::user()->role !== 'admin') {
            abort(401);
        }

        $courses = User::whereHas('courses', function ($query) {
            $query->whereIn('course_user.status', ['pending', 'true']);
        })->get();

        return $courses;
    }
}
