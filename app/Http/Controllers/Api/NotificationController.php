<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Notification::all();
        return response()->json($notifications);
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

        $request->validate([
            'statement' => 'required',
            'content' => 'required',
            'status' => 'required',
            'date' => 'required',
            'lawyer_id'=>'required'
        ]);

        $notification = Notification::create($request->all());

        return response()->json($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $notification = Notification::findOrFail($id);
        return response()->json($notification);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'statement' => 'required',
            'content' => 'required',
            'status' => 'required',
            'date' => 'required',
            'lawyer_id'=>'required'
        ]);

        $notification->update($request->all());

        return response()->json($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response()->json($notification);
    }
}
