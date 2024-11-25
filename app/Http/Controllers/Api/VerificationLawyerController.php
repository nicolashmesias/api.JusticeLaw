<?php

namespace App\Http\Controllers\Api;

use App\Models\VerificationLawyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class VerificationLawyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $verificationLawyers = VerificationLawyer::all();
        return response()->json($verificationLawyers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }




    public function getLevelOptions()
    {
        // Consulta para obtener los valores de la columna 'level' de la tabla 'verification_lawyers'
        $enumValues = DB::select(DB::raw('SHOW COLUMNS FROM verification_lawyers WHERE Field = "level"'));

        // Verifica que se obtuvieron resultados
        if (empty($enumValues)) {
            return response()->json(['error' => 'No se encontraron valores para la columna level'], 404);
        }

        // Extraer los valores del tipo enum
        preg_match("/^enum\((.*)\)$/", $enumValues[0]->Type, $matches);
        $enumValues = explode(",", $matches[1]);

        $enumValues = array_map(function ($value) {
            return trim($value, "'");
        }, $enumValues);

        return response()->json($enumValues);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cell_phone' => 'required|string|max:10',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'level' => 'required|in:Universidad,Maestría,Doctorado',
            'training_place' => 'required|string|max:255',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'lawyer_id' => 'required|exists:lawyers,id',
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'public');

        $verificationLawyer = VerificationLawyer::create([
            'cell_phone' => $validated['cell_phone'],
            'country_id' => $validated['country_id'],
            'state_id' => $validated['state_id'],
            'city_id' => $validated['city_id'],
            'level' => $validated['level'],
            'training_place' => $validated['training_place'],
            'resume' => $resumePath,
            'lawyer_id' => $validated['lawyer_id'],
        ]);

        return response()->json([
            'message' => 'Registro creado exitosamente.',
            'data' => $verificationLawyer,
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $verificationLawyer = VerificationLawyer::findOrFail($id);
        return response()->json($verificationLawyer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VerificationLawyer $verificationLawyer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VerificationLawyer $verificationLawyer)
    {
        $request->validate([
            'cell_phone' => 'required|min:10',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'level' => 'required',
            'training_place' => 'required',
            'resume' => 'required',
            'lawyer_id' => 'required'
        ]);
        $verificationLawyer->update($request->all());

        return response()->json($verificationLawyer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VerificationLawyer $verificationLawyer)
    {
        $verificationLawyer->delete();
        return response()->json($verificationLawyer);
    }
}