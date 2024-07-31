<?php

namespace App\Http\Controllers\Api;

use App\Models\TypeDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypeDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeDocuments=TypeDocument::all();
        return response()->json($typeDocuments);
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
            'code' => 'required|max:10',
            'description' => 'required|string|max:255',
        ]);

        $typeDocument = TypeDocument::create($request->all());

        return response()->json($typeDocument);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $typeDocument = TypeDocument::findOrFail($id);
        return response()->json($typeDocument);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeDocument $typeDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeDocument $typeDocument)
    {
        $request->validate([
            'code' => 'required|max:10',
            'description' => 'required|string|max:255',
        ]);

        $typeDocument->update($request->all());

        return response()->json($typeDocument);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeDocument $typeDocument)
    {
        $typeDocument->delete();
        return response()->json($typeDocument);
    }
}
