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

    /**
     * Crear una nueva instancia de la notificación.
     */
    public function __construct($message)
    {
        $this->message = $message;
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
            'message' => $this->message['message'], // Mensaje de la notificación
            'question_id' => $this->message['pregunta_id'], // ID de la pregunta
            'answerer_name' => $this->message['answerer_name'], // Nombre del abogado que respondió
        ];
    }

    /**
     * Obtener la representación de la notificación por correo electrónico.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nueva respuesta a tu pregunta')
            ->line("{$this->message['answerer_name']} ha respondido a tu pregunta.")
            ->action('Ver respuesta', url("/questions/{$this->message['pregunta_id']}"))
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
            'message' => $this->message['message'], // Mensaje de la notificación
            'question_id' => $this->message['pregunta_id'], // ID de la pregunta
            'answerer_name' => $this->message['answerer_name'], // Nombre del abogado
        ];
    }
}
