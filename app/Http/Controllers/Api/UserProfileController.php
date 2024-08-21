<?php

namespace App\Http\Controllers\Api;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usersProfile=UserProfile::all();
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
            'profile_photo' => 'required|max:255|unique:users',
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
            'profile_photo' => 'required|max:255|unique:users',
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
}
