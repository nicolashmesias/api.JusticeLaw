<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews=Review::all();

        return response()->json($reviews); 
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
            'content' => 'required',  
            'date' => 'required',  
            'user_id' => 'required',  
            'lawyer_id' => 'required', 
        ]);

        $reviews=Review::create($request->all());
        return response()->json($reviews);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $id)
    {
        $review=Review::included()->findOrFail($id);

        return response()->json($review);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $request->validate([
            'content' => 'required',  
            'date' => 'required', 
            'user_id'=>'required',
            'lawyer_id'=>'required'
        ]);

        $review->update($request->all());

        return response()->json($review);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return response()->json($review);
    }
}
