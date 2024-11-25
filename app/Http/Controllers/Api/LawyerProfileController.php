<?php

namespace App\Http\Controllers\Api;

use App\Models\LawyerProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LawyerProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $lawyersProfile = LawyerProfile::all();
        $lawyersProfile = LawyerProfile::included()->get();
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
        return response()->json($lawyerProfile);
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

    public function updateLawyerProfile(Request $request)
    {
        $lawyer = auth()->user();

        $validatedData = $request->validate([
            'cell_phone' => 'nullable|string|max:15',
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'city_id' => 'nullable|exists:cities,id',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($lawyer->profile && $lawyer->profile->profile_photo) {
                Storage::disk('public')->delete($lawyer->profile->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile_photos', 'public');

            $validatedData['profile_photo'] = $path;
        }

        $lawyer->profile()->updateOrCreate(['lawyer_id' => $lawyer->id], $validatedData);

        return response()->json([
            'message' => 'Perfil actualizado con éxito',
            'photo' => isset($path) ? asset('storage/' . $path) : ($lawyer->profile->profile_photo ? asset('storage/' . $lawyer->profile->profile_photo) : null),
        ], 200);
    }

    public function getProfile(Request $request)
    {
        $lawyer = $request->user();

        $profile = $lawyer->profile;

        if ($profile) {
            $countryName = $profile->country ? $profile->country->name : null;
            $countryId = $profile->country ? $profile->country->id : null;
            $stateName = $profile->state ? $profile->state->name : null;
            $stateId = $profile->state ? $profile->state->id : null;
            $cityName = $profile->city ? $profile->city->name : null;
            $cityId = $profile->city ? $profile->city->id : null;

            return response()->json([
                'cell_phone' => $profile->cell_phone ?? '',
                'country' => $countryName ?? '',
                'country_id' => $countryId ?? '',
                'state' => $stateName ?? '',
                'state_id' => $stateId ?? '',
                'city' => $cityName ?? '',
                'city_id' => $cityId ?? '',
                'photo' => $profile->profile_photo ? url('storage/' . $profile->profile_photo) : null,
            ]);
        } else {
            return response()->json([
                'message' => 'Perfil no encontrado',
            ], 404);
        }
    }
}
