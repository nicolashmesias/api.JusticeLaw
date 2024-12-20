<?php

namespace App\Http\Controllers\Api;

use App\Models\LawyerProfile;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LawyerProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $lawyersProfile = LawyerProfile::all();
        
        return response()->json($lawyersProfile);
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
            'cell_phone' => 'required|max:15',
            'country_id' => 'required|max:10',
            'state_id' => 'required|max:10',
            'city_id' => 'required|max:10',
            'profile_photo' => 'required|max:255',
            'lawyer_id' => 'required|string|max:10'
        ]);

        $lawyerProfile = LawyerProfile::create($request->all());

        return response()->json($lawyerProfile);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $lawyerProfile = LawyerProfile::findOrFail($id);
        return $lawyerProfile;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LawyerProfile $lawyerProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LawyerProfile $lawyerProfile)
    {
        $request->validate([
            'cell_phone' => 'required|max:15',
            'country_id' => 'required|max:10',
            'state_id' => 'required|max:10',
            'city_id' => 'required|max:10',
            'profile_photo' => 'required|max:255',
            'lawyer_id' => 'required|string|max:10'
        ]);

        $lawyerProfile->update($request->all());

        return response()->json($lawyerProfile);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LawyerProfile $lawyerProfile)
    {
        $lawyerProfile->delete();
        return response()->json($lawyerProfile);
    }

    public function getProfile(Request $request)
    {
        $lawyer = Auth::guard('lawyer')->user();

        if (!$lawyer) {
            return response()->json([
                'message' => 'Usuario no autenticado.',
            ], 401);
        }

        $profile = $lawyer->profile;

        if ($profile) {
            return response()->json([
                    'biography' => $profile->biography,
                    'photo' => $profile->profile_photo ? url('storage/' . $profile->profile_photo) : '',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Perfil no encontrado',
            ], 404);
        }
    }

    public function updateOrCreateProfile(Request $request)
    {
        $lawyer = Auth::guard('lawyer')->user();

        if (!$lawyer) {
            return response()->json([
                'message' => 'Usuario no autenticado.',
            ], 401);
        }

        $validatedData = $request->validate([
            'biography' => 'required|string|min:1000', // Mínimo de 1000 caracteres
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validación de imagen
        ]);

        if (strlen($validatedData['biography']) < 1000) {
            return response()->json([
                'message' => 'La biografía debe tener al menos 1000 caracteres.',
            ], 400);
        }

        if ($request->hasFile('profile_photo')) {
            // Validación de foto
            $file = $request->file('profile_photo');
            $mimeType = $file->getClientMimeType();
            $validMimeTypes = ['image/jpeg', 'image/png', 'image/jpg'];

            if (!in_array($mimeType, $validMimeTypes)) {
                return response()->json([
                    'message' => 'La foto debe ser en formato JPEG, PNG o JPG.',
                ], 400);
            }

            if ($file->getSize() > 2048 * 1024) { // El tamaño máximo es 2MB
                return response()->json([
                    'message' => 'La foto no puede ser mayor de 2MB.',
                ], 400);
            }

            // Borrar la foto previa si existe
            if ($lawyer->profile && $lawyer->profile->profile_photo) {
                Storage::disk('public')->delete($lawyer->profile->profile_photo);
            }

            // Subir la nueva foto
            $pathProfilePhoto = $file->store('profile_photos', 'public');
            $validatedData['profile_photo'] = $pathProfilePhoto;
        }

        // Crear o actualizar el perfil
        $lawyer->profile()->updateOrCreate(
            ['lawyer_id' => $lawyer->id],
            [
                'biography' => $validatedData['biography'],
                'profile_photo' => $validatedData['profile_photo'] ?? $lawyer->profile->profile_photo,
            ]
        );

        return response()->json([
            'message' => 'Perfil actualizado con éxito',
            'biography' => $lawyer->profile->biography,
            'photo' => isset($pathProfilePhoto)
                ? asset('storage/' . $pathProfilePhoto)
                : ($lawyer->profile->profile_photo
                    ? asset('storage/' . $lawyer->profile->profile_photo)
                    : ''),
        ], 200);
    }


    public function getVerification(Request $request)
    {
        $lawyer = Auth::guard('lawyer')->user();

        if (!$lawyer) {
            return response()->json([
                'message' => 'Usuario no autenticado.',
            ], 401);
        }

        $verification = $lawyer->verificationLawyer;

        if ($verification) {
            $countryName = $verification->country ? $verification->country->name : null;
            $countryId = $verification->country ? $verification->country->id : null;
            $stateName = $verification->state ? $verification->state->name : null;
            $stateId = $verification->state ? $verification->state->id : null;
            $cityName = $verification->city ? $verification->city->name : null;
            $cityId = $verification->city ? $verification->city->id : null;

            return response()->json([
                'cell_phone' => $verification->cell_phone ?? '',
                'country' => $countryName ?? '',
                'country_id' => $countryId ?? '',
                'state' => $stateName ?? '',
                'state_id' => $stateId ?? '',
                'city' => $cityName ?? '',
                'city_id' => $cityId ?? '',
                'level' => $verification->level,
                'training_place' => $verification->training_place,
                'resume' => url('storage/' . $verification->resume),
            ], 200);
        } else {
            return response()->json([
                'message' => 'Verificación no encontrada',
            ], 404);
        }
    }

    public function updateOrCreateVerification(Request $request)
    {
        $lawyer = Auth::guard('lawyer')->user();

        if (!$lawyer) {
            return response()->json([
                'message' => 'Usuario no autenticado.',
            ], 401);
        }

        $validatedData = $request->validate([
            'cell_phone' => 'required|string',
            'country_id' => 'required|integer|exists:countries,id',
            'state_id' => 'required|integer|exists:states,id',
            'city_id' => 'required|integer|exists:cities,id',
            'level' => 'required|string',
            'training_place' => 'required|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('resume')) {
            if ($lawyer->verificationLawyer && $lawyer->verificationLawyer->resume) {
                Storage::disk('public')->delete($lawyer->verificationLawyer->resume);
            }
            $pathResume = $request->file('resume')->store('resumes', 'public');
            $validatedData['resume'] = $pathResume;
        }

        $lawyer->verificationLawyer()->updateOrCreate(
            ['lawyer_id' => $lawyer->id],
            [
                'cell_phone' => $validatedData['cell_phone'],
                'country_id' => $validatedData['country_id'],
                'state_id' => $validatedData['state_id'],
                'city_id' => $validatedData['city_id'],
                'level' => $validatedData['level'],
                'training_place' => $validatedData['training_place'],
                'resume' => $validatedData['resume'] ?? $lawyer->verificationLawyer->resume,
            ]
        );

        return response()->json([
            'message' => 'Verificación actualizada con éxito',
            'verification' => [
                'cell_phone' => $lawyer->verificationLawyer->cell_phone,
                'country' => $lawyer->verificationLawyer->country_id,
                'state' => $lawyer->verificationLawyer->state_id,
                'city' => $lawyer->verificationLawyer->city_id,
                'level' => $lawyer->verificationLawyer->level,
                'training_place' => $lawyer->verificationLawyer->training_place,
                'resume' => isset($pathResume)
                    ? asset('storage/' . $pathResume)
                    : ($lawyer->verificationLawyer->resume
                        ? asset('storage/' . $lawyer->verificationLawyer->resume)
                        : ''),
            ],
        ], 200);
    }

    public function getLawyerDetails(Request $request, $lawyerId)
    {
        $lawyer = Lawyer::find($lawyerId);

        if (!$lawyer) {
            return response()->json([
                'message' => 'Abogado no encontrado.',
            ], 404);
        }

        $profile = $lawyer->profile;

        $verification = $lawyer->verificationLawyer;

        $areas = $lawyer->areas()->pluck('name');

        return response()->json([
            'lawyer' => [
                'id' => $lawyer->id,
                'name' => $lawyer->name,
                'last_names' => $lawyer->last_names,
                'type_document_id' => $lawyer->type_document_id,
                'document_number' => $lawyer->document_number,
                'email' => $lawyer->email,
                'email_verified_at' => $lawyer->email_verified_at,
                'verification' => $lawyer->verification,
                'reset_code' => $lawyer->reset_code,
                'created_at' => $lawyer->created_at,
                'updated_at' => $lawyer->updated_at,
            ],
            'profile' => $profile ? [
                'biography' => $profile->biography,
                'photo' => $profile->profile_photo ? url('storage/' . $profile->profile_photo) : '',
            ] : null,
            'verification' => $verification ? [
                'cell_phone' => $verification->cell_phone ?? '',
                'country' => $verification->country ? $verification->country->name : '',
                'country_id' => $verification->country ? $verification->country->id : '',
                'state' => $verification->state ? $verification->state->name : '',
                'state_id' => $verification->state ? $verification->state->id : '',
                'city' => $verification->city ? $verification->city->name : '',
                'city_id' => $verification->city ? $verification->city->id : '',
                'level' => $verification->level,
                'training_place' => $verification->training_place,
                'resume' => $verification->resume ? url('storage/' . $verification->resume) : '',
            ] : null,
            'areas' => $areas,
        ], 200);
    }


}