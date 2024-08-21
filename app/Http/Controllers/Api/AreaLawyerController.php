<?php

namespace App\Http\Controllers\Api;
use App\Models\AreaLawyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class AreaLawyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areasLawyer=AreaLawyer::all();
        return response()->json($areasLawyer); 
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
            'area_id' => 'required',  
            'lawyer_id' => 'required',  
        ]);

        $areasLawyer=AreaLawyer::create($request->all());
        return response()->json($areasLawyer);
    }

    /**
     * Display the specified resource.
     */
    public function show(AreaLawyer $id)
    {
        $areasLawyer=AreaLawyer::included()->findOrFail($id);

        return response()->json($areasLawyer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AreaLawyer $areaLawyer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AreaLawyer $areaLawyer)
    {
        $request->validate([
            'area_id'=>'required',
            'lawyer_id'=>'required'
        ]);

        $areaLawyer->update($request->all());

        return response()->json($areaLawyer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AreaLawyer $areaLawyer)
    {
        $areaLawyer->delete();
        return response()->json($areaLawyer);
    }
}