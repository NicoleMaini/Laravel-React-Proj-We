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

        $customer_id = Auth::user()->id;

        $inscription_courses = User::with('courses')->find($customer_id);

        return $inscription_courses;
    }

    public function customerRequired($id)
    {
        if (Auth::user()->role !== 'customer') {
            abort(401);
        }
        // $customer = User::find(18);
        // $course_id = 4;
        // $newStatus = 'pending';
        // $pivot = $customer->courses()->where('course_id', $course_id)->first()->pivot;
        // $pivot->status = $newStatus;
        // $pivot->save();

        // return $pivot;
        // $customer = User::find(18);
        // $course_id = 4;

        // $customer = Auth::user();
        // $course_id = $id; // ID del corso che vuoi aggiornare
        // $newStatus = 'pending';
        // // Aggiungi il corso con lo stato specificato nella tabella pivot
        // $customer->courses()->attach($course_id, ['status' => $newStatus]);
        // // Verifica se la relazione è stata aggiunta correttamente
        // $pivot = $customer->courses()->where('course_id', $course_id)->first()->pivot;
        // return $pivot;
        $customer = Auth::user();
        $course_id = $id; // ID del corso che vuoi aggiornare
        $newStatus = 'pending';

        // Verifica se la relazione esiste già
        $existingPivot = $customer->courses()->where('course_id', $course_id)->first();

        if ($existingPivot) {
            // Se la relazione esiste, aggiorna lo stato nella tabella pivot
            $customer->courses()->updateExistingPivot($course_id, ['status' => $newStatus]);
        } else {
            // Se la relazione non esiste, crea una nuova relazione con lo stato specificato
            $customer->courses()->attach($course_id, ['status' => $newStatus]);
        }

        // Recupera e ritorna la relazione aggiornata
        $pivot = $customer->courses()->where('course_id', $course_id)->first()->pivot;
        return $pivot;
    }

    public function customerCancel($id)
    {
        if (Auth::user()->role !== 'customer') {
            abort(401);
        }
        // $customer_id = User::find(1);
        // $course_id = 2;
        $customer = Auth::user();
        $customer->courses()->detach($id);
        $customer->users()->detach(Auth::user()->id);
        // $course_id = $id; // ID del corso che vuoi aggiornare
        // $newStatus = 'false';
        // $pivot = $customer->courses()->where('course_id', $course_id)->first()->pivot;
        // $pivot->status = $newStatus;
        // $pivot->save();

        return $customer;
    }
}
