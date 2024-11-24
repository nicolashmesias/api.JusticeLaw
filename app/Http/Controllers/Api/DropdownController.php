<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\City;
use App\Models\State;


class DropdownController extends Controller
{
    public function indexCountry()
    {
        $countries = Country::all();
        return response()->json($countries);
    }
    /**
     * Display a listing of the resource.
     */
    public function indexCity()
    {
        $cities = City::all();
        return response()->json($cities);
    }




    public function indexStateByCountry($countryId)
    {
        $country = Country::find($countryId);

        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        $states = $country->states;

        return response()->json($states); 
    }

    public function indexCityByState($stateId)
    {
        $state = State::find($stateId);

        if (!$state) {
            return response()->json(['error' => 'State not found'], 404);
        }

        $cities = $state->cities;

        return response()->json($cities);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function createCountry() {}
    public function createCity()

    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function storeCountry(Request $request)
    {

        $request->validate([
            'code' => 'required|max:2',
            'name' => 'required|max:255',
            'phonecode' => 'required|max:4'
        ]);

        $country = Country::create($request->all());

        return response()->json($country);
    }

    public function storeCity(Request $request)
    {
        $request->validate([
            'state_id' => 'required|max:10',
            'name' => 'required|max:210'
        ]);

        $city = City::create($request->all());

        return response()->json($city);
    }

    /**
     * Display the specified resource.
     */

    public function showCountry($id)
    {
        $country = Country::findOrFail($id);
        return response()->json($country);
    }

    public function showCity($id)
    {
        $city = City::findOrFail($id);
        return response()->json($city);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editCountry(Country $country)
    {
        //

    }

    public function editCity(city $city) {}

    /**
     * Update the specified resource in storage.
     */

    public function updateCountry(Request $request, Country $country)
    {
        $request->validate([
            'code' => 'required|max:2',
            'name' => 'required|max:255',
            'phonecode' => 'required|max:4'
        ]);

        $country->update($request->all());

        return response()->json($country);
    }

    public function updateCity(Request $request, City $city)
    {
        $request->validate([
            'state_id' => 'required|max:10',
            'name' => 'required|max:210',
        ]);

        $city->update($request->all());

        return response()->json($city);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroyCountry(Country $country)
    {
        $country->delete();
        return response()->json($country);
    }

    public function destroyCity(City $city)
    {
        $city->delete();
        return response()->json($city);
    }

    /**
     * Display a listing of the resource.
     */
    public function indexState()
    {
        $states = State::all();
        return response()->json($states);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createState()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeState(Request $request)
    {
        $request->validate([
            'country_id' => 'required|max:10',
            'name' => 'required|max:210'
        ]);

        $state = State::create($request->all());

        return response()->json($state);
    }

    /**
     * Display the specified resource.
     */
    public function showState($id)
    {
        $state = City::findOrFail($id);
        return response()->json($state);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editState(city $city) {}

    /**
     * Update the specified resource in storage.
     */
    public function updateState(Request $request, State $state)
    {
        $request->validate([
            'country_id' => 'required|max:10',
            'name' => 'required|max:210',
        ]);

        $state->update($request->all());

        return response()->json($state);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyState(State $state)
    {
        $state->delete();
        return response()->json($state);
    }
}