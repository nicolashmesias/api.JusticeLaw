<?php

namespace App\Http\Controllers\Api;

use App\Models\UserProfile;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $usersProfile=UserProfile::all();
        $usersProfile = UserProfile::included()->get();
        return response()->json($usersProfile);
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
            'cell_phone' => 'required|max:10',
            'country_id' => 'required|max:10',
            'state_id' => 'required|max:10',
            'city_id' => 'required|max:10',
            'profile_photo' => 'required|max:255',
            'user_id' => 'required|string|max:10'
        ]);

        $userProfile = UserProfile::create($request->all());

        return response()->json($userProfile);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $userProfile = UserProfile::findOrFail($id);
        return response()->json($userProfile);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserProfile $userProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserProfile $userProfile)
    {
        $request->validate([
            'cell_phone' => 'required|max:10',
            'country_id' => 'required|max:10',
            'state_id' => 'required|max:10',
            'city_id' => 'required|max:10',
            'profile_photo' => 'required|max:255',
            'user_id' => 'required|string|max:10'
        ]);

        $userProfile->update($request->all());

        return response()->json($userProfile);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserProfile $userProfile)
    {
        $userProfile->delete();
        return response()->json($userProfile);
    }

    public function updateUserProfile(Request $request)
    {
        $user = auth()->user(); // Obtener el usuario autenticado

        // Validar los datos recibidos
        $validatedData = $request->validate([
            'cell_phone' => 'nullable|string|max:15',
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'city_id' => 'nullable|exists:cities,id',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Máximo 2 MB
        ]);

        // Procesar la imagen de perfil si se proporciona
        if ($request->hasFile('profile_photo')) {
            // Eliminar la imagen anterior si existe
            if ($user->profile && $user->profile->profile_photo) {
                Storage::disk('public')->delete($user->profile->profile_photo);
            }

            // Guardar la nueva imagen en el almacenamiento público
            $path = $request->file('profile_photo')->store('profile_photos', 'public');

            // Guardar el path en el array validado
            $validatedData['profile_photo'] = $path;
        }

        // Actualizar o crear el perfil del usuario
        $user->profile()->updateOrCreate(['user_id' => $user->id], $validatedData);

        // Devolver la URL completa de la foto, o mantener la existente si no se cambió
        return response()->json([
            'message' => 'Perfil actualizado con éxito',
            'photo' => isset($path) ? asset('storage/' . $path) : ($user->profile->profile_photo ? asset('storage/' . $user->profile->profile_photo) : null),
        ], 200);
    }

    // Controlador en backend
public function getProfile(Request $request)
{
    $user = $request->user();

    return response()->json([
        'cell_phone' => $user->cell_phone ?? '',
        'country_id' => $user->country_id ?? '',
        'state_id' => $user->state_id ?? '',
        'city_id' => $user->city_id ?? '',
        'photo' => $user->profile_photo ? url('storage/profile_photos/' . $user->profile_photo) : null, 
    ]);
}

}