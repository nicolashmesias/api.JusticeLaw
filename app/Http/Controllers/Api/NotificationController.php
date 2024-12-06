<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Notifications\Notification;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Notifications\NewNotification;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
   
    /**
     * Obtener notificaciones no leídas.
     */
    public function index()
    {
        try {
            // Obtén el usuario autenticado
            $user = auth()->user();
    
            // Asegúrate de que el usuario esté autenticado
            if (!$user) {
                return response()->json(['message' => 'Usuario no autenticado'], 401);
            }
    
            // Consulta directa a la tabla de notificaciones
            $notifications = DatabaseNotification::where('notifiable_id', $user->id)
                                                 ->where('notifiable_type', get_class($user))
                                                 ->orderBy('created_at', 'desc') // Ordena por la más reciente
                                                 ->get();
    
            // Verifica si hay notificaciones
            if ($notifications->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'No hay notificaciones disponibles.',
                    'notifications' => []
                ]);
            }
    
            // Retorna las notificaciones
            return response()->json([
                'success' => true,
                'notifications' => $notifications
            ]);
    
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = auth()->user()->notifications->find($id);

        if (!$notification) {
            return response()->json(['error' => 'Notificación no encontrada.'], 404);
        }

        $notification->markAsRead();
        return response()->json(['message' => 'Notificación marcada como leída.'], 200);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['message' => 'Todas las notificaciones marcadas como leídas.'], 200);
    }

    public function destroy($id)
{
    // Obtener la notificación de un usuario autenticado
    $notification = auth()->user()->notifications->find($id);

    if (!$notification) {
        return response()->json(['error' => 'Notificación no encontrada.'], 404);
    }

    try {
        $notification->delete();
        return response()->json(['message' => 'Notificación eliminada.'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al eliminar la notificación.'], 500);
    }
}

public function destroyAll()
{
    try {
        $user = auth()->user();
        // Eliminar todas las notificaciones del usuario autenticado
        $user->notifications->delete();
        return response()->json(['message' => 'Todas las notificaciones eliminadas.'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al eliminar todas las notificaciones.'], 500);
    }
}
    /**
     * Manejo de "me gusta" en una notificación.
     */
    public function likeNotification($id)
    {
        // Encuentra la notificación por ID
        $notification = DatabaseNotification::findOrFail($id);
    
        // Verifica que el usuario autenticado sea el destinatario de la notificación
        $user = auth()->user();
        if ($notification->notifiable_id !== $user->id || $notification->notifiable_type !== get_class($user)) {
            return response()->json(['message' => 'No autorizado para interactuar con esta notificación'], 403);
        }
    
        // Recupera los datos de la notificación y asegúrate de que 'liked' esté inicializado
        $data = collect($notification->data);
        $liked = $data->get('liked', false); // Valor por defecto: no le ha dado "like"
    
        // Alterna el estado de "me gusta"
        $data['liked'] = !$liked;
        $message = $data['liked'] ? 'Me gusta añadido' : 'Me gusta eliminado';
    
        // Actualiza los datos de la notificación
        $notification->update(['data' => $data->toArray()]);
    
        return response()->json([
            'success' => true,
            'message' => $message,
            'liked' => $data['liked'], // Estado actual del "like"
        ]);
    }
    

    
    public function show($id)
{
    $notification = DatabaseNotification::find($id);

    if (!$notification) {
        return response()->json(['message' => 'Notificación no encontrada'], 404);
    }

    return response()->json($notification);
}
}
