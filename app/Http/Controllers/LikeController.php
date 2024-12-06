<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Question;

class LikeController extends Controller
{
    // Obtener conteos de likes y dislikes por pregunta
    public function getLikes($questionId)
    {
        $likesCount = Like::where('question_id', $questionId)->where('is_like', true)->count();
    $dislikesCount = Like::where('question_id', $questionId)->where('is_like', false)->count();

    return response()->json([
        'likes_count' => $likesCount,
        'dislikes_count' => $dislikesCount,
    ]);
    }

    // Crear un like o dislike
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'user_id' => 'required|exists:users,id',
            'is_like' => 'required|boolean',
        ]);

        $like = Like::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'question_id' => $request->question_id,
            ],
            ['is_like' => $request->is_like]
        );

        return response()->json([
            'message' => 'Like/Dislike actualizado correctamente',
            'like' => $like,
        ]);
    }
}

