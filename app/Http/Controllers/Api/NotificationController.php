<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Notifications\Notification;
use App\Http\Controllers\Controller;
use App\Notifications\NewNotification;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Enviar una nueva notificación.
     */
    public function sendNotification(Request $request)
    {
        $user = auth()->user(); // Obtener el usuario autenticado

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado.',
            ], 401);
        }

        // Validar los datos
        $request->validate([
            'message' => 'required|string',
            'pregunta_id' => 'required|integer',
            'answerer_name' => 'required|string',
        ]);

        // Construir los datos del mensaje
        $messageData = [
            'message' => $request->message,
            'pregunta_id' => $request->pregunta_id,
            'answerer_name' => $request->answerer_name,
        ];

        // Crear la notificación y enviarla
        try {
            $user->notify(new NewNotification($messageData));

            return response()->json([
                'success' => true,
                'message' => 'Notificación enviada correctamente.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar la notificación.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener notificaciones no leídas.
     */
    public function index()
    {
        try {
            $user = auth()->user();
            $notifications = cache()->remember("user_{$user->id}_unread_notifications", 60, function () use ($user) {
                return $user->unreadNotifications->take(10);
            });

            return response()->json([
                'success' => true,
                'notifications' => $notifications,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Marcar como leída una notificación.
     */
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications->find($id);

        if ($notification) {
            $notification->markAsRead();

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
     */
    public function destroy($id)
    {
        $notification = auth()->user()->notifications->find($id);

        if ($notification) {
            $notification->delete();

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
     */
    public function archive($id)
    {
        $notification = auth()->user()->notifications->find($id);

        if ($notification) {
            $data = $notification->data;
            $data['archived'] = true;
            $notification->update(['data' => $data]);

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
     * Eliminar todas las notificaciones.
     */
    public function destroyAll()
    {
        auth()->user()->notifications->delete();

        return response()->json([
            'success' => true,
            'message' => 'Todas las notificaciones fueron eliminadas',
        ]);
    }

    /**
     * Archivar todas las notificaciones.
     */
    public function archiveAll()
    {
        auth()->user()->notifications->each(function ($notification) {
            $data = $notification->data;
            $data['archived'] = true;
            $notification->update(['data' => $data]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Todas las notificaciones fueron archivadas',
        ]);
    }

    /**
     * Manejo de "me gusta" en una notificación.
     */
    public function likeNotification($id)
    {
        $notification = DatabaseNotification::findOrFail($id);
        $userId = auth()->id();

        $data = collect($notification->data);

        $likes = collect($data->get('likes', []));

        if ($likes->contains($userId)) {
            $likes = $likes->reject(fn($id) => $id === $userId);
            $message = 'Me gusta eliminado';
        } else {
            $likes->push($userId);
            $message = 'Me gusta añadido';
        }

        $data['likes'] = $likes->values()->all();
        $notification->update(['data' => $data->toArray()]);

        return response()->json([
            'message' => $message,
            'likes_count' => $likes->count(),
        ]);
    }

}
