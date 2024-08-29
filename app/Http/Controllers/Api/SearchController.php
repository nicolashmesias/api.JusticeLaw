<?php

namespace App\Http\Controllers\Api;

use App\Models\Search;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $searchs = Search::all();
        return response()->json($searchs);
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

            'fecha' => 'required',
            'information_id' => 'required',

        ]);

        $search = Search::create($request->all());

        return response()->json($search);
    }

    /**
     * Display the specified resource.
     */
    public function show(Search $id)
    {
        $search = Search::findOrFail($id);
        return response()->json($search);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Search $search)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Search $search)
    {
        $request->validate([

            'fecha' => 'required',
            'information_id' => 'required',

        ]);

        $search->update($request->all());

        return response()->json($search);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Search $search)
    {
        $search->delete();
        return response()->json($search);
    }
}
