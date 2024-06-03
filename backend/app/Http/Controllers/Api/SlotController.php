<?php

namespace App\Http\Controllers\Api;

use App\Models\Slot;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSlotRequest;
use App\Http\Requests\UpdateSlotRequest;

class SlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slots = Slot::with('courses', 'courses.activity')->get();
        return $slots;
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
    public function store(StoreSlotRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $slot = Slot::with('activity', 'courses')->find($id);
        if (!$slot) {
            return response(['status' => 'Not found'], 404); // torna sempre status 200
        }
        return ['data' => $slot];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slot $slot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSlotRequest $request, Slot $slot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slot $slot)
    {
        //
    }
}
