<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Consulting;
use App\Models\Lawyer;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'content' => 'required|string',
            'stars' => 'required|integer|min:1|max:5',
            'lawyer_id' => 'required|exists:lawyers,id',
        ]);

        $hasInteracted = Consulting::whereHas('question', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->whereHas('answer', function ($query) use ($validatedData) {
            $query->where('lawyer_id', $validatedData['lawyer_id']);
        })->exists();

        if (!$hasInteracted) {
            return response()->json([
                'message' => 'Tienes que haber interactuado con el abogado para calificarlo.',
            ], 403);
        }

        $review = Review::create([
            'content' => $validatedData['content'],
            'stars' => $validatedData['stars'],
            'user_id' => $user->id,
            'lawyer_id' => $validatedData['lawyer_id'],
            'date' => now(),
        ]);

        return response()->json([
            'message' => 'Reseña creada con éxito.',
            'review' => $review,
        ], 201);
    }


    public function index(Request $request, $lawyer_id)
    {
        $lawyerExists = Lawyer::find($lawyer_id);
    
        if (!$lawyerExists) {
            return response()->json([
                'message' => 'El abogado no existe.',
            ], 404);
        }
    
        $reviews = Review::where('lawyer_id', $lawyer_id)
            ->orderBy('date', 'desc') 
            ->with('user:id,name,last_name') 
            ->get();
    
        return response()->json([
            'message' => 'Reseñas obtenidas con éxito.',
            'reviews' => $reviews,
        ], 200);
    }
    
}
