<?php

namespace App\Http\Controllers\Api;

use App\Models\Search;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Muestra todas las búsquedas (puedes filtrar por usuario si es necesario).
     */


     public function registrarVista(Request $request)
{
    // Validamos que el usuario haya enviado el ID de la información y que esté autenticado
    $request->validate([
        'informacion_id' => 'required|integer', // ID de la información que se está viendo
    ]);

    // Registrar la vista en la tabla 'searches'
    \App\Models\Search::create([
        'usuario_id' => auth()->id(), // Asumimos que el usuario está autenticado
        'informacion_id' => $request->informacion_id,
        'fecha' => now(), // Fecha y hora actual
    ]);

    return response()->json(['message' => 'Vista registrada correctamente']);
}

    public function index()
    {
        $searches = Search::with(['information', 'lawyer'])->orderBy('fecha', 'desc')->get();
        return response()->json($searches);
    }

    /**
     * Registra una búsqueda o vista en el historial.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id', // Puede ser null para usuarios no autenticados
            'lawyer_id' => 'nullable|exists:lawyers,id',
            'information_id' => 'required|exists:information,id', // Es obligatorio
        ]);

        // Crea el registro en la tabla `searches`
        $search = Search::create([
            'fecha' => now(),
            'user_id' => $validated['user_id'] ?? null,
            'lawyer_id' => $validated['lawyer_id'] ?? null,
            'information_id' => $validated['information_id'],
        ]);

        return response()->json($search, 201);
    }

    /**
     * Muestra el historial de búsquedas para un usuario específico.
     */
    public function getHistory(Request $request)
    {
        // Opcional: filtra por usuario autenticado
        $userId = $request->query('user_id'); // Puedes enviar el ID por query string o autenticarlo
        $query = Search::with(['information', 'lawyer'])->orderBy('fecha', 'desc');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $history = $query->get();

        return response()->json($history, 200);
    }

    /**
     * Muestra un registro específico.
     */
    public function show($id)
    {
        $search = Search::with(['information', 'lawyer'])->findOrFail($id);
        return response()->json($search);
    }

    /**
     * Actualiza un registro específico.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'information_id' => 'required|exists:information,id',
            'lawyer_id' => 'nullable|exists:lawyers,id',
        ]);

        $search = Search::findOrFail($id);
        $search->update($validated);

        return response()->json($search);
    }

    /**
     * Elimina un registro del historial.
     */
    public function destroy($id)
    {
        $search = Search::findOrFail($id);
        $search->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }
}
