<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;

class DropdownController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexCity()
    {
        $cities = City::all();
        return response()->json($cities);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createCity()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCity(Request $request)
    {
        $request->validate([
            'state_id' => 'required|min:10',
            'name' => 'required|max:210'
        ]);

        $city = City::create($request->all());

        return response()->json($city);
    }

    /**
     * Display the specified resource.
     */
    public function showCity($id)
    {
        $city = City::findOrFail($id);
        return response()->json($city);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editCity(city $city)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCity(Request $request, City $city)
    {
        $request->validate([
            'status_id' => 'required|min:20',
            'name' => 'required|max:210',
        ]);

        $city->update($request->all());

        return response()->json($city);
    }

    /**
     * Remove the specified resource from storage.
     */
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
            'country_id' => 'required|min:10',
            'name' => 'required|max:210'
        ]);

        $city = City::create($request->all());

        return response()->json($city);
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
    public function editState(city $city)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateState(Request $request, State $state)
    {
        $request->validate([
            'country_id' => 'required|min:20',
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
