<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Consulting;
use App\Models\Question;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function visitors()
    {
        // Obtener datos de visitantes agrupados por mes (puedes modificar la consulta dependiendo de tu modelo)
        $visitors = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = $visitors->pluck('month')->map(function ($month) {
            return date('F', mktime(0, 0, 0, $month, 1)); // Convertir el número del mes a nombre
        });

        $data = $visitors->pluck('total');

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function usersByRole()
    {
        try {
            // Verificar qué guard está autenticado
            $user = auth()->user();
            
            if (!$user) {
                return response()->json(['error' => 'No se ha encontrado un usuario autenticado'], 401);
            }

            // Usar el guard para determinar el tipo de usuario
            $role = 'user'; // Por defecto 'user', pero puede cambiar según el guard

            if (auth('lawyer')->check()) {
                $role = 'lawyer';
            } elseif (auth('administrator')->check()) {
                $role = 'admin';
            }

            // Ahora que sabemos el rol, podemos realizar la consulta
            $data = DB::table('users')
                ->select(DB::raw('role, COUNT(*) as user_count'))
                ->groupBy('role')
                ->get();

            // Retornar los datos de la gráfica
            return response()->json($data);

        } catch (\Exception $e) {
            // Si ocurre un error, devolvemos una respuesta con un código 500
            return response()->json(['error' => 'Error al obtener los datos para la gráfica'], 500);
        }
    }
}
