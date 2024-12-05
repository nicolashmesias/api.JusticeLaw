<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewNotification extends Notification
{
    use Queueable;

    private $message;
    private $questionId;
    private $answererName;

    /**
     * Crear una nueva instancia de la notificación.
     */
    public function __construct($message, $questionId, $answererName)
    {
        $this->message = $message;
        $this->questionId = $questionId;
        $this->answererName = $answererName;
    }

    /**
     * Obtener los canales de entrega de la notificación.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Preparar los datos para almacenar en la base de datos.
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message, // Mensaje de la notificación
            'question_id' => $this->questionId, // ID de la pregunta
            'answerer_name' => $this->answererName, // Nombre del abogado que respondió
        ];
    }

    /**
     * Obtener la representación de la notificación por correo electrónico.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nueva respuesta a tu pregunta')
            ->line("{$this->answererName} ha respondido a tu pregunta.")
            ->action('Ver respuesta', url("/questions/{$this->questionId}"))
            ->line('Gracias por usar nuestra plataforma.');
    }

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
            'answerer_name' => $this->answererName, // Nombre del abogado
        ];
    }
}
