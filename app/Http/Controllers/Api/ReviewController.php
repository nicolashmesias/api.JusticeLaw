<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Consulting;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // Obtiene el usuario autenticado
        $user = auth()->user();

        // Valida los datos de entrada
        $validatedData = $request->validate([
            'content' => 'required|string',
            'stars' => 'required|integer|min:1|max:5',
            'lawyer_id' => 'required|exists:lawyers,id',
        ]);

        // Verifica si el usuario ha tenido interacción con el abogado
        $hasInteracted = Consulting::whereHas('question', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->whereHas('answer', function ($query) use ($validatedData) {
            $query->where('lawyer_id', $validatedData['lawyer_id']);
        })->exists();

        // Si no hay interacción, regresa un mensaje de error
        if (!$hasInteracted) {
            return response()->json([
                'message' => 'Tienes que haber interactuado con el abogado para calificarlo.',
            ], 403);
        }

        // Crea la reseña si la validación es correcta
        $review = Review::create([
            'content' => $validatedData['content'],
            'stars' => $validatedData['stars'],
            'user_id' => $user->id,
            'lawyer_id' => $validatedData['lawyer_id'],
            'date' => now(), // Fecha actual
        ]);

        return response()->json([
            'message' => 'Reseña creada con éxito.',
            'review' => $review,
        ], 201); 
    }
}