<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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

    public function indexr()
    {
        $likes = Like::all();
        return response()->json($likes);
    }

    public function indexlogin()
    {
        $questions = Question::all();
        return response()->json($questions);
    }


    public function toggleReaction(Request $request, $postId)
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Validar el cuerpo de la solicitud
        $request->validate([
            'is_like' => 'required|boolean',
        ]);

        // Buscar si ya existe un like/dislike del usuario en este post
        $like = Like::where('user_id', $user->id)->where('post_id', $postId)->first();

        if ($like) {
            if ($like->is_like == $request->is_like) {
                // Si el usuario repite la misma reacción, eliminarla
                $like->delete();
            } else {
                // Si el usuario cambia de reacción, actualizarla
                $like->update(['is_like' => $request->is_like]);
            }
        } else {
            // Si no existe una reacción previa, crearla
            Like::create([
                'user_id' => $user->id,
                'post_id' => $postId,
                'is_like' => $request->is_like,
            ]);
        }

        // Retornar el conteo actualizado de likes y dislikes
        $likesCount = Like::where('post_id', $postId)->where('is_like', true)->count();
        $dislikesCount = Like::where('post_id', $postId)->where('is_like', false)->count();

        return response()->json([
            'likes' => $likesCount,
            'dislikes' => $dislikesCount,
        ]);
    }

    /**
     * Obtener todas las reacciones para un post específico.
     */
    public function getReactions($Id)
    {
        $likes = Like::where('question_id', $Id)->where('is_like', true)->count();
        $dislikes = Like::where('question_id', $Id)->where('is_like', false)->count();

        return response()->json([
            'likes' => $likes,
            'dislikes' => $dislikes,
        ]);
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
                'affair' => 'required|string|max:255',
                'user_id' => 'required|integer',
                'forum_category_id' => 'required|integer',
                'date_publication' => 'required|date',
                'content' => 'required|string',
            ]);
    
            // Crear una nueva pregunta en la base de datos
            $question = Question::create([
                'affair' => $validatedData['affair'],
                'user_id' => $validatedData['user_id'],
                'forum_category_id' => $validatedData['forum_category_id'],
                'date_publication' => $validatedData['date_publication'],
                'content' => $validatedData['content'],
            ]);
    
            // Responder con un mensaje de éxito y los datos creados
            return response()->json([
                'message' => 'Pregunta creada con éxito.',
                'data' => $question
            ], 201);
        }
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
            'affair' => 'required|max:255',
            'content' => 'required|string|min:8',
            'date_publication' => 'required|string|min:8',
            'user_id' => 'required|max:10',
            'forum_category_id' => 'required|max:210'
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
