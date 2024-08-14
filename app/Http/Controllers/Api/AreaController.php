<?php

namespace App\Http\Controllers\Api;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas=Area::all();

        return response()->json($areas);
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
            'name' => 'required',  
        ]);

        $areas=Area::create($request->all());
        return response()->json($areas);
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $id)
    {
        $area=Area::included()->findOrFail($id);

        return response()->json($area);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $area->update($request->all());

        return response()->json($area);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        $area->delete();
        return response()->json($area);
    }
}
