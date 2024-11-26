<?php

namespace App\Http\Controllers\Api;
use App\Models\AreaLawyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

        request();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lawyer = Auth::guard('lawyer')->user();

        if (!$lawyer) {
            return response()->json([
                'message' => 'Usuario no autenticado.',
            ], 401);
        }

        $validated = $request->validate([
            'lawyer_id' => 'required|exists:lawyers,id',
            'areas' => 'required|array',
            'areas.*' => 'exists:areas,id'
        ]);

        // Guardar las relaciones entre el abogado y las áreas seleccionadas
        foreach ($validated['areas'] as $areaId) {
            AreaLawyer::create([
                'lawyer_id' => $validated['lawyer_id'],
                'area_id' => $areaId
            ]);
        }

        return response()->json(['message' => 'Áreas guardadas correctamente']);
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
