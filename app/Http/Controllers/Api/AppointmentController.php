<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $dates=Appointment::all();

       return response()->json($dates);
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
    public function store(Request $request)
    {
        $request ->validate([
            'date' =>'required|max:255',
            'startTime' =>'required|max:255',
            'state'=>'required|max:255',
            'endTime'=>'required|max:255'
        ]);
        
        $appointment=Appointment::created($request->all());

        return response()->json($appointment);
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        $appointment=Appointment::included()->finOrFail($id);
        return response()->json($appointment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
           'date' =>'required|max:255',
            'startTime' =>'required|max:255',
            'state'=>'required|max:255',
            'endTime'=>'required|max:255'
        ]);

       $appointment->update($request->all());
        return response()->json($appointment);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json($appointment);
    }
}
