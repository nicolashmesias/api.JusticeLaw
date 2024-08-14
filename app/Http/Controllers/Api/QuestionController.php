<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::all();
        return response()->json($questions);
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
            'affair' => 'required|max:255',
            'content' => 'required|string|min:8',
            'date_publication' => 'required|string|min:8',
            'user_id' => 'required|min:10',
            'forum_category_id' => 'required|max:210'
        ]);

        $question = Question::create($request->all());

        return response()->json($question);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $question = Question::findOrFail($id);
        return response()->json($question);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'lawyer_id' => 'required|min:10',
            'question_id' => 'required|max:210',
            'affair' => 'required|max:255',
            'content' => 'required|string|min:8',
            'date_publication' => 'required|string|min:8'
        ]);

        $question->update($request->all());

        return response()->json($question);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json($question);
    }
}
