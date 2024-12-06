<?php

namespace App\Http\Controllers\Api;

use App\Models\Lawyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\User;
use App\Models\Question;
use App\Notifications\NewNotification;
use Illuminate\Support\Facades\Validator;

class LawyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $lawyers=Lawyer::all();
        $lawyers = Lawyer::included()->get();
        return response()->json($lawyers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    public function me()
    {
        $guards = ['api', 'lawyer', 'administrator'];
    
        foreach ($guards as $guard) {
            if (auth($guard)->check()) {
                return response()->json(auth($guard)->user());
            }
        }
    
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    
    

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function registerLawyer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'last_names' => 'required|max:50',
            'type_document_id' => 'required|max:10',
            'document_number' => 'required|max:10',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($this->emailExistsInAnyTable($request->email)) {
            return response()->json(['error' => 'El correo ya está registrado en el sistema.'], 400);
        }


        $lawyer = new Lawyer();
        $lawyer->name = $request->name;
        $lawyer->last_names = $request->last_names;
        $lawyer->type_document_id = $request->type_document_id;
        $lawyer->document_number = $request->document_number;
        $lawyer->email = $request->email;
        $lawyer->password = bcrypt($request->password);
        $lawyer->verification = false;
        $lawyer->save();

        return response()->json($lawyer, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $lawyer = Lawyer::findOrFail($id);
        return response()->json($lawyer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lawyer $lawyer)
    {
        $request->validate([
            'name' => 'required|max:30',
            'last_name' => 'required|max:50',
            'type_document_id' => 'required|max:10',
            'document_number' => 'required|max:10',
            'email' => 'required|max:255',
            'password' => 'required|string|min:8'
        ]);

        // $request->merge(['password' => bcrypt($request->password)]);

        $lawyer->update($request->all());

        return response()->json($lawyer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lawyer $id)
    {  $lawyer = Lawyer::find($id);

     
    
        // Eliminar la pregunta
        $lawyer->delete();
    
        // Responder con un mensaje de éxito
        return response()->json([
            'message' => 'Pregunta eliminada con éxito.'
        ], 200);
    }

    private function emailExistsInAnyTable($email)
    {
        return User::where('email', $email)->exists() ||
               Lawyer::where('email', $email)->exists() ||
               Administrator::where('email', $email)->exists();
    }

    public function respondToQuestion(Request $request, $questionId , $id)
    {
        // 1. Encuentra la pregunta que está siendo respondida
        $question = Question::findOrFail($questionId);
        
        // 2. Encuentra al usuario que hizo la pregunta
        $user = User::findOrFail($question->user_id);

        $lawyer = Lawyer::findOrFail($id);
        // 3. Información para la notificación
        $message = [
            'message' => 'Tu pregunta ha recibido una respuesta.',
            'pregunta_id' => $question->id,
            'answerer_name' => $lawyer->name, // Puede ser el nombre del abogado que responde
        ];

        // 4. Enviar la notificación al usuario
        $user->notify(new NewNotification($message));

        // 5. Retorna una respuesta indicando éxito
        return response()->json(['message' => 'Respuesta enviada y notificación enviada.']);
    }

}
