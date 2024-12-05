<?php

namespace App\Http\Controllers\Api;

use App\Models\Information;
use App\Models\Search;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show($id, Request $request)
    {
        try {
            // Buscar la información por ID
            $information = Information::with('forumcategory')->findOrFail($id);

            // Registrar la vista en el historial
            Search::create([
                'fecha' => now(),
                'user_id' => $request->user_id ?? null, // ID del usuario si está autenticado
                'information_id' => $id,
            ]);

            // Retornar la información encontrada
            return response()->json($information, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Información no encontrada.'], 404);
        }
    }

    public function index(Request $request)
    {
        // Obtiene todos los registros de la base de datos
        $informations = Information::query();

        // Si hay una búsqueda en el request, aplica un filtro
        if ($request->has('search')) {
            $search = $request->input('search');
            $informations->where('title', 'like', '%' . $search . '%')
                         ->orWhere('content', 'like', '%' . $search . '%');
        }

        // Recupera los datos
        $informations = $informations->get();

        // Si no hay datos, retorna un mensaje vacío
        if ($informations->isEmpty()) {
            return view('information.index', ['informations' => [], 'message' => 'No se encontraron resultados.']);
        }

        // Retorna la vista con los datos

        return response()->json($informations);
        // return view('information.index', compact('informations'));
    }




public function view(Request $request)
{
    // Obtén el parámetro de búsqueda
    $query = $request->input('query');

    if ($query) {
        // Realiza la búsqueda
        $informations = Information::where('name', 'like', "%{$query}%")
            ->orWhere('body', 'like', "%{$query}%")
            ->get();
    } else {
        // Obtiene todas las informaciones si no hay búsqueda
        $informations = Information::all();
    }

    // Maneja el caso en el que no se encuentren resultados
    if ($informations->isEmpty()) {
        return view('information.index', [
            'informations' => [],
            'message' => 'No se encontraron resultados para tu búsqueda.'
        ]);
    }

    // Retorna la vista con las informaciones encontradas
    return view('information.index', compact('informations'));
}


// En tu controlador
public function search(Request $request)
{
    $query = $request->input('search');
    $informations = Information::where('name', 'like', '%' . $query . '%')->get();
    return response()->json($informations);
}


    // Si no hay término de búsqueda, retornar un array vacío




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
            'name' => 'required|max:100',
            'body' => 'required',
            'cover_photo' => 'required',
            'category' => 'required|max:1',
        ]);

        $information = Information::create($request->all());

        return response()->json($information);
    }

    /**
     * Display the specified resource.
     */
    public function getInformationDetails(Request $request, $informationId)
{
    // Buscar la información por ID
    $information = Information::with('forumcategory') // Asegúrate de que la relación con forumcategory esté definida
        ->find($informationId);

    if (!$information) {
        return response()->json([
            'message' => 'Información no encontrada.',
        ], 404);
    }

    // Si necesitas, puedes obtener más relaciones aquí (por ejemplo, foros o cualquier otra cosa relacionada con la información)
    // $additionalData = $information->someRelation;

    return response()->json([
        'information' => [
            'id' => $information->id,
            'name' => $information->name,
            'body' => $information->body,
            'cover_photo' => $information->cover_photo ? url('storage/' . $information->cover_photo) : null,
            'created_at' => $information->created_at,
            'updated_at' => $information->updated_at,
        ],
        'category' => $information->forumcategory ? [
            'name' => $information->forumcategory->name,
            'id' => $information->forumcategory->id,
        ] : null,
    ], 200);
}



    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Information $information)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Information $information)
    {
        $request->validate([
            'name' => 'required|max:100',
            'body' => 'required',
            'cover_photo' => 'required',
            'category' => 'required|max:1',
        ]);

        $information->update($request->all());

        return response()->json($information);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Information $information)
    {
        $information->delete();
        return response()->json($information);
    }
}
