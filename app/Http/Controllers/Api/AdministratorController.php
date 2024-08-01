<?php

namespace App\Http\Controllers\Api;

use App\Models\Administrator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $administrators = Administrator::all();
        return response()->json($administrators);
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
            'type_document_id' => 'required|max:10',
            'document_number' => 'required|max:10',
            'email' => 'required|max:255',
            'password' => 'required|string|min:8'
        ]);

        $administrator = Administrator::create($request->all());

        return response()->json($administrator);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $administrator = Administrator::findOrFail($id);
        return response()->json($administrator);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Administrator $administrator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Administrator $administrator)
    {
        $request->validate([
            'type_document_id' => 'required|max:10',
            'document_number' => 'required|max:10',
            'email' => 'required|max:255',
            'password' => 'required|string|min:8'
        ]);

        $request->merge(['password' => bcrypt($request->password)]);
        $administrator->update($request->all());

        return response()->json($administrator);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Administrator $administrator)
    {
        $administrator->delete();
        return response()->json($administrator);
    }
}