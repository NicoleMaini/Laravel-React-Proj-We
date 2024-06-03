<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function customerDashboard()
    {
        if (Auth::user()->role !== 'customer') {
            abort(401);
        }

        // $customer_id = Auth::user()->id;
        $customer_id = 1;

        $inscription_courses = User::with('courses')->find($customer_id);

        return $inscription_courses;
    }

    public function customerRequired($id)
    {
        if (Auth::user()->role !== 'customer') {
            abort(401);
        }

        // $customer_id = Auth::user;
        // $course_id = $id; // ID del corso che vuoi aggiornare
        $customer_id = User::find(1);
        $course_id = 2;
        $newStatus = 'pending';
        $pivot = $customer_id->courses()->where('course_id', $course_id)->first()->pivot;
        $pivot->status = $newStatus;
        $pivot->save();

        return $pivot;
    }
}
