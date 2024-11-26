<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Consulting;
use App\Models\Question;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function clients()
    {
        // Obtener datos de usuarios registrados agrupados por mes
        $clients = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = $clients->pluck('month')->map(function ($month) {
            return date('F', mktime(0, 0, 0, $month, 1)); // Convertir el número del mes a nombre
        });

        $data = $clients->pluck('total');

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function reviews()
    {
        // Obtener cantidad de reseñas agrupadas por mes
        $reviews = Review::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = $reviews->pluck('month')->map(function ($month) {
            return date('F', mktime(0, 0, 0, $month, 1));
        });

        $data = $reviews->pluck('total');

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function information()
    {
        // Obtener datos de publicaciones agrupadas por mes
        $information = Question::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = $information->pluck('month')->map(function ($month) {
            return date('F', mktime(0, 0, 0, $month, 1));
        });

        $data = $information->pluck('total');

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function sessions()
    {
        // Obtener datos de sesiones agrupadas por mes
        $sessions = Consulting::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = $sessions->pluck('month')->map(function ($month) {
            return date('F', mktime(0, 0, 0, $month, 1));
        });

        $data = $sessions->pluck('total');

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}
