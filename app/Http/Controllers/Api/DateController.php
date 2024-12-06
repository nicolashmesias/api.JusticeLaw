<?php

namespace App\Http\Controllers\Api;

use App\Models\Date;
use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dates = Date::all();
        $forumCategories = Date::included()->get();

        return response()->json($dates);
    }

    public function store(Request $request)
    {
        // Obtener el abogado autenticado
        $lawyer = Auth::guard('lawyer')->user();

        if (!$lawyer) {
            return response()->json([
                'message' => 'Usuario no autenticado.',
            ], 401);
        }

        // Validar los datos enviados desde el cliente
        $validatedData = $request->validate([
            'date' => 'required',
            'state' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
        ]);

        // Crear una nueva disponibilidad en la base de datos
        $date = Date::create([
            'date' => $validatedData['date'],
            'state' => $validatedData['state'],
            'startTime' => $validatedData['startTime'],
            'endTime' => $validatedData['endTime'],
            'lawyer_id' => $lawyer->id, // Usar el ID del abogado autenticado
        ]);

        // Responder con un mensaje de éxito y los datos creados
        return response()->json([
            'message' => 'Disponibilidad creada con éxito.',
            'data' => $date
        ], 201);
    }


    public function getAvailabilities(Request $request)
{
    // Obtener el abogado autenticado
    $lawyer = Auth::guard('lawyer')->user();

    if (!$lawyer) {
        return response()->json([
            'message' => 'Usuario no autenticado.',
        ], 401);
    }

    // Obtener las disponibilidades del abogado autenticado
    $disponibilities = $lawyer->dates; // Suponiendo que el modelo 'Lawyer' tiene una relación con el modelo 'Date'

    if ($disponibilities->isEmpty()) {
        return response()->json([
            'message' => 'No se encontraron disponibilidades.',
        ], 404);
    }

    // Retornar las disponibilidades
    return response()->json([
        'disponibilities' => $disponibilities->map(function ($date) {
            return [
                'date' => $date->date,
                'state' => $date->state,
                'startTime' => $date->startTime,
                'endTime' => $date->endTime,
            ];
        }),
    ], 200);
}



public function calendarioAbogado(Request $request, $lawyerId)
{
    // Buscar al abogado por su ID
    $lawyer = Lawyer::find($lawyerId);

    if (!$lawyer) {
        return response()->json([
            'message' => 'Abogado no encontrado.',
        ], 404);
    }

    // Obtener las disponibilidades del abogado
    $disponibilities = $lawyer->dates; // Suponiendo que el modelo 'Lawyer' tiene una relación con el modelo 'Date'

    // Verificar si existen disponibilidades
    if ($disponibilities->isEmpty()) {
        return response()->json([
            'message' => 'No se encontraron disponibilidades.',
        ], 404);
    }

    // Retornar las disponibilidades
    return response()->json([
        'disponibilities' => $disponibilities->map(function ($date) {
            return [

                'date' => $date->date,
                'state' => $date->state,
                'startTime' => $date->startTime,
                'endTime' => $date->endTime,
            ];
        }),
    ], 200);
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $date = Date::included()->findOrFail($id);

        return response()->json($date);
    }

    public function update(Request $request, Date $date)
    {
        $request->validate([
            'date' => 'required|max:255',
            'state' => 'required|max:255',
            'startTime' => 'require|max:255',
            'endTime' => 'require|max:255',
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
