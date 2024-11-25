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
        $user = auth()->user();

        $validatedData = $request->validate([
            'cell_phone' => 'nullable|string|max:15',
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'city_id' => 'nullable|exists:cities,id',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile && $user->profile->profile_photo) {
                Storage::disk('public')->delete($user->profile->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile_photos', 'public');

            $validatedData['profile_photo'] = $path;
        }

        $user->profile()->updateOrCreate(['user_id' => $user->id], $validatedData);

        return response()->json([
            'message' => 'Perfil actualizado con éxito',
            'photo' => isset($path) ? asset('storage/' . $path) : ($user->profile->profile_photo ? asset('storage/' . $user->profile->profile_photo) : null),
        ], 200);
    }

    public function getProfile(Request $request)
    {
        $user = $request->user();

        $profile = $user->profile;

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