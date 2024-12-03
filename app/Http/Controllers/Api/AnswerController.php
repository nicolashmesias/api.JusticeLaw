<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Notifications\NewNotification;
use App\Models\Question;
use Carbon\Carbon;
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
        {
            // Validar los datos enviados desde el cliente
            $validatedData = $request->validate([
                'content' => 'required|string|max:255',
                'lawyer_id' => 'required',
                'question_id' => 'required',
                'date_publication' => 'required|date',
            ]);
    

            // Crear una nueva pregunta en la base de datos
            $answer = Answer::create([
                'content' => $validatedData['content'],
                'lawyer_id' => $validatedData['lawyer_id'],
                'question_id' => $validatedData['question_id'],
                'date_publication' => $validatedData['date_publication']
            ]);
    
            // Responder con un mensaje de éxito y los datos creados
            return response()->json([
                'message' => 'Pregunta creada con éxito.',
                'data' => $answer
            ], 201);
        }
     }
    /**
     * Display the specified resource.
    


    
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
            'lawyer_id' => 'required',
            'question_id' => 'required|max:210',
            'affair' => 'required|max:255',
            'content' => 'required|string|min:5',
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
