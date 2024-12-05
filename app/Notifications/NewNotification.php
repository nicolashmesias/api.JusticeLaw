<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewNotification extends Notification
{
    protected $message;
    protected $questionId;
    protected $lawyerName;

    public function __construct($message, $questionId, $lawyerName)
    {
        $this->message = $message;
        $this->questionId = $questionId;
        $this->lawyerName = $lawyerName;
    }

    public function via($notifiable)
    {
        return ['database']; // Asegúrate de tener 'database' y 'mail' si quieres enviar una notificación por ambos métodos.
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'question_id' => $this->questionId,
            'lawyer_name' => $this->lawyerName,
        ];
    }

    /**
     * Obtener la representación de la notificación por correo electrónico.
     */

    /**
     * Obtener la representación de la notificación en forma de arreglo.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message, // Mensaje de la notificación
            'question_id' => $this->questionId, // ID de la pregunta
            'answerer_name' => $this->lawyerName, // Nombre del abogado
        ];
    }
}
