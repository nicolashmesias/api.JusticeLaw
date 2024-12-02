<?php

namespace App\Http\Controllers\Api;

use App\Models\Date;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dates=Date::all();
        $forumCategories = Date::included()->get();

        return response()->json($dates);
    }

    public function store(Request $request)
    {
       

        {
            // Validar los datos enviados desde el cliente
            $validatedData =  $request->validate([
                'date'=>'required',
                'state'=>'required',
                'startTime'=>'required',
                'endTime'=>'required',
                'lawyer_id' => 'required',

            ]);
    
            // Crear una nueva pregunta en la base de datos
            $date = Date::create([
                'date' => $validatedData['date'],
                'state' => $validatedData['state'],
                'startTime' => $validatedData['startTime'],
                'endTime' => $validatedData['endTime'],
                'lawyer_id' => $validatedData['lawyer_id'],
            ]);
    
            // Responder con un mensaje de éxito y los datos creados
            return response()->json([
                'message' => 'Pregunta creada con éxito.',
                'data' => $date
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $date=Date::included()->findOrFail($id);

        return response()->json($date);
    }

    public function update(Request $request, Date $date)
    {
        $request->validate([
            'date'=>'required|max:255',
            'state'=>'required|max:255',
            'startTime'=>'require|max:255',
            'endTime'=>'require|max:255',
        ]);

        $date->update($request->all());

        return response()->json($date);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Date $date)
    {
        $date->delete();
        return response()->json($date);
    }
}
