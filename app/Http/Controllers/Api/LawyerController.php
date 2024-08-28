<?php

namespace App\Http\Controllers\Api;

use App\Models\Date;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LawyerController extends Controller
{
    public function index()
    {
        $lawyers=Lawyer::all();

        return response()->json($lawyers);
    
    }

    public function store(Request $request)
    {
        $request->validate([
          'name' => 'required|max:30',
            'last_names' => 'required|max:50',
            'type_document_id' => 'required|max:10',
            'document_number' => 'required|max:13',
            'email' => 'required|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $lawyer=Lawyer::create($request->all());

        return response()->json($lawyer);
    }

    public function show($id)
    {
        $lawyer=Lawyer::included()->findOrFail($id);

        return response()->json($lawyer);
    }

    public function update(Request $request, Lawyer $lawyer)
    {
        $request->validate([
            'name' => 'required|max:30',
            'last_name' => 'required|max:50',
            'type_document_id' => 'required|max:10',
            'document_number' => 'required|max:13',
            'email' => 'required|max:255',
            'password' => 'required|string|min:8'
        ]);

        
        $lawyer->update($request->all());

        return response()->json($lawyer);
    }

    public function destroy(Lawyer $lawyer)
    {
        $lawyer->delete();
        return response()->json($lawyer);
    }
}
