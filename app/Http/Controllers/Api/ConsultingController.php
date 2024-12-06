<?php

namespace App\Http\Controllers\Api;

use App\Models\Consulting;
use App\Http\Controllers\Controller;
use App\Models\Date;
use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;

class ConsultingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consultings = Consulting::all();

        return response()->json($consultings);
    }


    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'answer_id' => 'required|exists:answers,id',
            'question_id' => 'required|exists:questions,id',
        ]);

        // Obtener el lawyer_id asociado al answer_id
        $answer = Answer::findOrFail($validated['answer_id']);
        $lawyerId = $answer->lawyer_id;

        // Obtener la disponibilidad correspondiente
        $date = Date::where('date', $validated['date'])
                    ->where('startTime', $validated['time'])
                    ->where('lawyer_id', $lawyerId)
                    ->firstOrFail();

        // Guardar la consulta
        $consulting = Consulting::create([
            'date' => $validated['date'],
            'time' => $validated['time'],
            'answer_id' => $validated['answer_id'],
            'question_id' => $validated['question_id']
        ]);

        // Actualizar el estado de la disponibilidad
        $date->update(['state' => 'Agendada']);

        return response()->json([
            'message' => 'Asesoría creada con éxito.',
            'consulting' => $consulting
        ], 201);
    }




    public function getUserQuestionsWithAnswers(Request $request)
    {
        $user = $request->user(); // Obtén el usuario logueado

        // Obtén las preguntas hechas por el usuario
        $questions = $user->questions()->with(['answers' => function ($query) use ($request) {
            // Filtra las respuestas asociadas al lawyer_id específico
            $query->where('lawyer_id', $request->lawyer_id);
        }])->get();

        if ($questions->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron preguntas asociadas al usuario logueado.',
            ], 404);
        }

        // Formatea la respuesta
        $formattedQuestions = $questions->map(function ($question) {
            return [
                'id' => $question->id,
                'affair' => $question->affair,
                'content' => $question->content,
                'date_publication' => $question->date_publication,
                'answers' => $question->answers->map(function ($answer) {
                    return [
                        'id' => $answer->id,
                        'content' => $answer->content,
                        'date_publication' => $answer->date_publication,
                    ];
                }),
            ];
        });

        return response()->json($formattedQuestions);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $consulting = Consulting::included()->findOrFail($id);
        return response()->json($consulting);
    }

    public function update(Request $request, Consulting $consulting)
    {
        $request->validate([
            'date' => 'required|max:255',
            'time' => 'required|max:255',
            'price' => 'required|double|max:255'
        ]);

        $consulting->update($request->all());
        return response()->json($consulting);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consulting $consulting)
    {
        $consulting->delete();
        return response()->json($consulting);
    }
    public function acceptAdvisory(Request $request, $id)
    {
        $advisory = Consulting::findOrFail($id);
        $advisory->status = 'accepted';
        $advisory->save();

        $calendarService = new GoogleCalendarService();
        $event = $calendarService->createMeetEvent(
            'Asesoría con ' . $advisory->lawyer->name,
            $advisory->start_time,
            $advisory->end_time,
            [$advisory->user->email, $advisory->lawyer->email]
        );

        return response()->json([
            'message' => 'Asesoría aceptada y reunión creada',
            'meet_link' => $event->getHangoutLink(),
        ]);
    }
}