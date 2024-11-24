<?php

namespace App\Http\Controllers\Api;

use App\Models\Lawyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LawyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $lawyers=Lawyer::all();
        $lawyers = Lawyer::included()->get();
        return response()->json($lawyers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:30',
            'last_name' => 'required|max:50',
            'type_document_id' => 'required|max:10',
            'document_number' => 'required|max:10',
            'email' => 'required|max:255|unique:lawyers',
            'password' => 'required|string|min:8'
        ]);

        $lawyer = Lawyer::create($request->all());

        return response()->json($lawyer);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $lawyer = Lawyer::findOrFail($id);
        return response()->json($lawyer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lawyer $lawyer)
    {
        $request->validate([
            'name' => 'required|max:30',
            'last_name' => 'required|max:50',
            'type_document_id' => 'required|max:10',
            'document_number' => 'required|max:10',
            'email' => 'required|max:255',
            'password' => 'required|string|min:8'
        ]);

        // $request->merge(['password' => bcrypt($request->password)]);

        $lawyer->update($request->all());

        return response()->json($lawyer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lawyer $lawyer)
    {
        $lawyer->delete();
        return response()->json($lawyer);
    }
}
