<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Activity;
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
        })
            ->with([
                'courses' => function ($query) {
                    $query->whereIn('course_user.status', ['pending', 'true'])->select('courses.*', 'course_user.status');
                },
            ])
            ->get();

        $result = $courses->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'genre' => $user->genre,
                'telephone' => $user->telephone,
                'email' => $user->email,
                'courses' => $user->courses
                    ->map(function ($course) {
                        $activity = Activity::with('courses', 'courses.slot')->find($course->id);
                        // Assicurati che l'istanza di Activity sia stata recuperata correttamente
                        if ($activity) {
                            // Ora puoi accedere al nome del corso tramite la relazione Activity
                            return [
                                'id' => $course->id,
                                'name' => $activity->name,
                                'status' => $course->pivot->status,
                            ];
                        } else {
                            // Nel caso in cui l'istanza di Activity non sia stata trovata
                            return [
                                'id' => $course->id,
                                'status' => $course->pivot->status,
                            ];
                        }
                    })
                    ->filter(), // Rimuovi eventuali valori null dalla mappatura dei corsi
            ];
        });

        return json_encode($result, JSON_PRETTY_PRINT);
    }

    public function adminAccept($customer_id, $course_id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(401);
        }

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
