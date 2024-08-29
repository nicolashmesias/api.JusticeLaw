<?php

namespace App\Http\Controllers\Api;

use App\Models\LawyerProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LawyerProfileController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lawyerProfile = LawyerProfile::all();
        return response()->json($lawyerProfile);
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
            'profile_photo' => 'required',
            'biography' => 'required',
            'lawyer_id'=>'required'
        ]);

        $lawyerProfile = LawyerProfile::create($request->all());

        return response()->json($lawyerProfile);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $lawyerProfile = LawyerProfile::findOrFail($id);
        return response()->json($lawyerProfile);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LawyerProfile $lawyerProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LawyerProfile $lawyerProfile)
    {
        $request->validate([

            'profile_photo' => 'required',
            'biography' => 'required',
            'lawyer_id'=>'required'

        ]);

        $lawyerProfile->update($request->all());

        return response()->json($lawyerProfile);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LawyerProfile $lawyerProfile)
    {
        $lawyerProfile->delete();
        return response()->json($lawyerProfile);
    }
}
