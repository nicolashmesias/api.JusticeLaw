<?php

namespace App\Http\Controllers\Api;

use App\Models\OverhaulReview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class OverhaulReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $overhaulReview = OverhaulReview::all();
        return response()->json($overhaulReview);
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
    
            'administrators_id' => 'required',
            'review_id'=>'required'
        ]);

        $overhaulReview = OverhaulReview::create($request->all());

        return response()->json($overhaulReview);
    }

    /**
     * Display the specified resource.
     */
    public function show($id )
    {
        $overhaulReview = OverhaulReview::findOrFail($id);
        return response()->json($overhaulReview);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OverhaulReview $overhaulReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OverhaulReview $overhaulReview)
    {
        $request->validate([

             'administrators_id' => 'required',
            'review_id'=>'required'
                        
        ]);

        $overhaulReview->update($request->all());

        return response()->json($overhaulReview);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OverhaulReview $overhaulReview)
    {
        $overhaulReview->delete();
        return response()->json($overhaulReview);
    }
}