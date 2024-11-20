<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Notifications\NewNotification;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
     /**
     * Obtener notificaciones no leídas del usuario autenticado.
     */
    public function index()
    {
        $user = auth()->user(); // Usuario autenticado
        $notificacions = $user->unreadNotifications->paginate(10); // paginar notificaciones 10 por consulta 
        $notificacions = $user->unreadNotifications; // Relación directa
        $notificacions = cache()->remember("user_{$user->id}_notifications", 60, function () use ($user) {
            return $user->unreadNotifications->get();
        });

        return response()->json([
            'success' => true,
            'notifications' => $notificacions,
        ]);
    }

    /**
     * Marcar una notificación como leída.
     *
     * @param string $id
     */
    public function markAsRead($id)
    {
        $user = auth()->user();
        $notificacion = $user->notifications->find($id);

        if ($notificacion) {
            $notificacion->markAsRead(); // Marcar como leída
            return response()->json([
                'success' => true,
                'message' => 'Notificación marcada como leída',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Notificación no encontrada',
        ], 404);
    }

    /**
     * Eliminar una notificación.
     *
     * @param string $id
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $notificacion = $user->notifications->find($id);

        if ($notificacion) {
            $notificacion->delete(); // Eliminar notificación
            return response()->json([
                'success' => true,
                'message' => 'Notificación eliminada correctamente',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Notificación no encontrada',
        ], 404);
    }

    /**
     * Archivar una notificación.
     *
     * @param string $id
     */
    public function archive($id)
    {
        $user = auth()->user();
        $notificacion = $user->notifications->find($id);

        if ($notificacion) {
            $data = $notificacion->data;
            $data['archived'] = true; // Agrega un campo "archived"
            $notificacion->update(['data' => $data]);

            return response()->json([
                'success' => true,
                'message' => 'Notificación archivada',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Notificación no encontrada',
        ], 404);
    }

    /**
     * Eliminar todas las notificaciones del usuario autenticado.
     */
    public function destroyAll()
    {
        $user = auth()->user();
        $user->notifications->delete(); // Eliminar todas las notificaciones

        return response()->json([
            'success' => true,
            'message' => 'Todas las notificaciones fueron eliminadas',
        ]);
    }

    /**
     * Archivar todas las notificaciones del usuario autenticado.
     */
    public function archiveAll()
    {
        $user = auth()->user();
        $user->notifications->each(function ($notificacion) {
            $data = $notificacion->data;
            $data['archived'] = true; // Agrega un campo "archived"
            $notificacion->update(['data' => $data]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Todas las notificaciones fueron archivadas',
        ]);
    }

    // manejo de likes en notificaciones 
    public function likeNotification($id)
    {
    $notification = DatabaseNotification::findOrFail($id);
    $userId = auth()->id();

    // Extraer datos actuales
    $data = $notification->data;

    // Manejar "me gusta"
    if (!isset($data['likes'])) {
        $data['likes'] = [];
    }

    if (in_array($userId, $data['likes'])) {
        // Si el usuario ya dio "me gusta", eliminarlo
        $data['likes'] = array_diff($data['likes'], [$userId]);
        $message = 'Me gusta eliminado';
    } else {
        // Si no, añadirlo
        $data['likes'][] = $userId;
        $message = 'Me gusta añadido';
    }

    // Guardar cambios
    $notification->data = $data;
    $notification->save();

    return response()->json(['message' => $message, 'likes_count' => count($data['likes'])]);
    }

}
