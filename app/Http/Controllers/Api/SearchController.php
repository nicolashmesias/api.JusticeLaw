<?php

namespace App\Http\Controllers\Api;

use App\Models\Search;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class SearchController extends Controller
{
    /**
     * Muestra todas las búsquedas (puedes filtrar por usuario si es necesario).
     */

     

     public function registrarVista(Request $request)
     {
         // Validar que se haya enviado un ID válido de la información
         $validated = $request->validate([
             'informacion_id' => 'required|integer|exists:informacions,id', // Asegúrate que exista en la tabla de "informacions"
         ]);
 
         // Registrar la vista en la tabla "searches"
         try {
             // Guardar la información en la tabla "searches"
             Search::create([
                 'informacion_id' => $validated['informacion_id'],
                 'user_id' => Auth::id(), // Si tienes autenticación, guarda el ID del usuario autenticado
             ]);
 
             return response()->json(['message' => 'Vista registrada correctamente.'], 200);
         } catch (\Exception $e) {
             return response()->json(['error' => 'Hubo un error al registrar la vista.'], 500);
         }
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
    $informacion = Search::findOrFail($id);
    $usuarioId = auth()->id(); // Obtener el ID del usuario autenticado

    // Guardar la visita en la base de datos
    DB::table('visitas')->insert([
        'usuario_id' => $usuarioId,
        'informacion_id' => $id,
        'fecha_visita' => now()
    ]);

    return view('informacion.show', compact('informacion'));
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
