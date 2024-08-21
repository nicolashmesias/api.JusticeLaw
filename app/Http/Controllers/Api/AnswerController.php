<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $answers = Answer::all();
        return response()->json($answers);
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
            'lawyer_id' => 'required|min:10',
            'question_id' => 'required|max:210',
            'affair' => 'required|max:255',
            'content' => 'required|string|min:8',
            'date_publication' => 'required|string|min:8'
        ]);

        $answer = Answer::create($request->all());

        return response()->json($answer);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $answer = Answer::findOrFail($id);
        return response()->json($answer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $answer)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Answer $answer)
    {
        $request->validate([
            'lawyer_id' => 'required|min:10',
            'question_id' => 'required|max:210',
            'affair' => 'required|max:255',
            'content' => 'required|string|min:8',
            'date_publication' => 'required|string|min:8'
        ]);

        $answer->update($request->all());

        return response()->json($answer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        $answer->delete();
        return response()->json($answer);
    }
}
