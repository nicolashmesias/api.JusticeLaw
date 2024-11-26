<?php

namespace App\Http\Controllers\Api;

use App\Models\Consulting;
use App\Http\Controllers\Controller;
use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;

class ConsultingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consultings=Consulting::all();

        return response()->json($consultings);
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'date'=>'required|max:255',
            'time'=>'required|max:255',
            'price'=>'required|max:255',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $consulting=Consulting::included()->findOrFail($id);
        return response()->json($consulting);
    }

    public function update(Request $request, Consulting $consulting)
    {
        $request->validate([
            'date'=>'required|max:255',
            'time'=>'required|max:255',
            'price'=>'required|double|max:255'
        ]);

        $consulting->update($request->all());
        return response()->json($consulting);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consulting $consulting)
    {
        $consulting->delete();
        return response()->json($consulting);
    }
    public function acceptAdvisory(Request $request, $id)
{
    $advisory = Consulting::findOrFail($id);
    $advisory->status = 'accepted';
    $advisory->save();

    $calendarService = new GoogleCalendarService();
    $event = $calendarService->createMeetEvent(
        'Asesoría con ' . $advisory->lawyer->name,
        $advisory->start_time,
        $advisory->end_time,
        [$advisory->user->email, $advisory->lawyer->email]
    );

    return response()->json([
        'message' => 'Asesoría aceptada y reunión creada',
        'meet_link' => $event->getHangoutLink(),
    ]);
}
}
