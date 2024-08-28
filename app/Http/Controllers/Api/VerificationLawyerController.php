<?php

namespace App\Http\Controllers;

use App\Models\VerificationLawyer;
use Illuminate\Http\Request;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cell_phone' => 'required|min:10',
            'country_id' => 'required|max:210',
            'state_id' => 'required|max:255',
            'city_id' => 'required|numeric|max:20',
            'lawyer_id' => 'required|numeric|max:8'
        ]);

        $verificationLawyer = VerificationLawyer::create($request->all());

        return response()->json($verificationLawyer);
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
            'country_id' => 'required|max:210',
            'state_id' => 'required|max:255',
            'city_id' => 'required|numeric|max:20',
            'lawyer_id' => 'required|numeric|max:8'
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
