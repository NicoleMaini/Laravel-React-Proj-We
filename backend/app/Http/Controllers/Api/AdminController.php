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
    public function adminAccept($customer_id, $course_id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(401);
        }

        // $customer = User::find(1);
        // $course_id = 2;
        $customer = User::find($customer_id);
        if (!$customer) {
            // Gestione dell'errore se l'utente non viene trovato
            return response()->json(['error' => 'Utente non trovato.'], 404);
        }

        $newStatus = 'true';
        $pivot = $customer->courses()->where('course_id', $course_id)->first()->pivot;

        if (!$pivot) {
            // Gestione dell'errore se il corso non viene trovato per l'utente
            return response()->json(['error' => 'Corso non trovato per questo utente.'], 404);
        }

        $pivot->status = $newStatus;
        $pivot->save();

        $courses = $customer->courses;

        return $courses;
    }

    public function adminReject($customer_id, $course_id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(401);
        }

        $customer = User::find($customer_id);
        if (!$customer) {
            return response()->json(['error' => 'Utente non trovato.'], 404);
        }

        $newStatus = 'false';
        $pivot = $customer->courses()->where('course_id', $course_id)->first()->pivot;

        if (!$pivot) {
            return response()->json(['error' => 'Corso non trovato per questo utente.'], 404);
        }

        $pivot->status = $newStatus;
        $pivot->save();

        $courses = $customer->courses;

        return $courses;
    }
}
