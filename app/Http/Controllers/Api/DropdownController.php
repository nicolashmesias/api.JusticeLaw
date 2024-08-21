<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;

class DropdownController extends Controller
{
    public function indexCountry()
    {
        $countries=Country::all();
        return response()->json($countries);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createCountry()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCountry(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255',
        ]);

        $country = Country::create($request->all());

        return response()->json($country);
    }

    /**
     * Display the specified resource.
     */
    public function showCountry($id)
    {
        $country = Country::findOrFail($id);
        return response()->json($country);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editCountry(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCountry(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $country->update($request->all());

        return response()->json($country);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyCountry(Country $country)
    {
        $country->delete();
        return response()->json($country);
    }
}
