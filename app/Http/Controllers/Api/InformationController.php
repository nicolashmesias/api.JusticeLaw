<?php

namespace App\Http\Controllers\Api;

use App\Models\Information;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $informations=Information::all();
        return response()->json($informations);
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
            'name' => 'required|max:100',
            'body' => 'required',
            'cover_photo' => 'required',
            'category' => 'required|max:1',
        ]);

        $information = Information::create($request->all());

        return response()->json($information);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $information = Information::findOrFail($id);
        return response()->json($information);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Information $information)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Information $information)
    {
        $request->validate([
            'name' => 'required|max:100',
            'body' => 'required',
            'cover_photo' => 'required',
            'category' => 'required|max:1',
        ]);

        $information->update($request->all());

        return response()->json($information);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Information $information)
    {
        $information->delete();
        return response()->json($information);
    }
}
