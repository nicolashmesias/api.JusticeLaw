<?php

namespace App\Http\Controllers\Api;

use App\Models\Date;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dates=Date::all();

        return response()->json($dates);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date'=>'required|max:255',
            'state'=>'required|string|max:255',
            'startTime'=>'required|max:255',
            'endTime'=>'required|max:255',
        ]);

        $date=Date::create($request->all());

        return response()->json($date);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $date=Date::included()->findOrFail($id);

        return response()->json($date);
    }

    public function update(Request $request, Date $date)
    {
        $request->validate([
            'date'=>'required|max:255',
            'state'=>'required|max:255',
            'startTime'=>'require|max:255',
            'endTime'=>'require|max:255',
        ]);

        $date->update($request->all());

        return response()->json($date);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Date $date)
    {
        $date->delete();
        return response()->json($date);
    }
}
