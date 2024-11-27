<?php

namespace App\Http\Controllers\Api;

use App\Models\Information;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    $query = $request->get('query');

    // Buscar las informaciones que coincidan con la búsqueda
    $informations = Information::where('title', 'like', '%' . $query . '%')->get();

    return response()->json($informations);
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
 
    public function show($id)
{
    try {
        // Buscar la información por ID, incluyendo la relación con `forumcategory`
        $information = Information::with('forumcategory') // Asume que existe una relación con la tabla `forumcategories`
            ->findOrFail($id);

        // Retornar la información como JSON
        return response()->json($information, 200);
    } catch (\Exception $e) {
        // Si ocurre un error (como no encontrar el registro), devolver un error
        return response()->json([
            'message' => 'No se pudo encontrar la información solicitada.'
        ], 404);
    }
}

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
