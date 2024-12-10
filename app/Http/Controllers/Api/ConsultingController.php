<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ZoomController;
use App\Models\Consulting;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Date;
use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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


    // public function store(Request $request)
    // {
    //     // Validar los datos recibidos
    //     $validated = $request->validate([
    //         'date' => 'required|date',
    //         'time' => 'required',
    //         'answer_id' => 'required|exists:answers,id',
    //         'question_id' => 'required|exists:questions,id',
    //     ]);

    //     // Obtener el lawyer_id asociado al answer_id
    //     $answer = Answer::findOrFail($validated['answer_id']);
    //     $lawyerId = $answer->lawyer_id;

    //     // Obtener la disponibilidad correspondiente
    //     $date = Date::where('date', $validated['date'])
    //                 ->where('startTime', $validated['time'])
    //                 ->where('lawyer_id', $lawyerId)
    //                 ->firstOrFail();

    //     // Guardar la consulta
    //     $consulting = Consulting::create([
    //         'date' => $validated['date'],
    //         'time' => $validated['time'],
    //         'answer_id' => $validated['answer_id'],
    //         'question_id' => $validated['question_id']
    //     ]);

    //     // Actualizar el estado de la disponibilidad
    //     $date->update(['state' => 'Agendada']);

    //     return response()->json([
    //         'message' => 'Asesoría creada con éxito.',
    //         'consulting' => $consulting,
    //         'zoom_url' => $consulting->zoom_url // Incluye el enlace de Zoom
    //     ], 201);
    // }

    public function store(Request $request)
{
    // Validar los datos recibidos
    $validated = $request->validate([
        'date' => 'required|date',
        'time' => 'required',
        'question_id' => 'required|exists:questions,id',
        'answer_id' => 'required|exists:answers,id',
        'zoom_url' => 'nullable|url', // Enlace de Zoom opcional
    ]);

    // Obtener el lawyer_id asociado al answer_id
    $answer = Answer::findOrFail($validated['answer_id']);
    $lawyerId = $answer->lawyer_id;

    // Validar la disponibilidad del abogado
    $date = Date::where('date', $validated['date'])
        ->where('startTime', $validated['time'])
        ->where('lawyer_id', $lawyerId)
        ->firstOrFail();

    // Guardar la consulta
    $consulting = Consulting::create([
        'date' => $validated['date'],
        'time' => $validated['time'],
        'question_id' => $validated['question_id'],
        'answer_id' => $validated['answer_id'],
        'zoom_url' => $validated['zoom_url'] ?? null,
    ]);

    // Actualizar el estado de la disponibilidad
    $date->update(['state' => 'Agendada']);

    // Llamada al método para crear la reunión de Zoom
    try {
        // Crear una instancia del controlador de Zoom
        $zoomController = new ZoomController();
        // Llamar al método createMeeting y pasar el ID de la consulta
        $zoomResponse = $zoomController->createMeeting($consulting->id);

        // Si la reunión fue creada con éxito, se obtiene el zoom_url
        if (isset($zoomResponse->original['zoom_url'])) {
            // Actualizar el zoom_url en la base de datos
            $consulting->update(['zoom_url' => $zoomResponse->original['zoom_url']]);

            return response()->json([
                'message' => 'Asesoría creada con éxito.',
                'consulting' => $consulting,
                'zoom_url' => $zoomResponse->original['zoom_url'], // Incluye el enlace de Zoom
            ], 201);
        }

        // Si la reunión no se creó correctamente
        return response()->json(['error' => 'No se pudo crear la reunión de Zoom'], 500);

    } catch (\GuzzleHttp\Exception\RequestException $e) {
        Log::error("Error en la solicitud a Zoom: " . $e->getMessage());
        if ($e->hasResponse()) {
            $responseBody = $e->getResponse()->getBody();
            Log::error('Respuesta de error de Zoom: ' . $responseBody);
            Log::error('Código de respuesta: ' . $e->getResponse()->getStatusCode());
        }
        return response()->json(['error' => 'No se pudo crear la reunión de Zoom'], 500);
    }
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
