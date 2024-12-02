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
     * Create a new notification instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Prepare the data to store in the database.
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nueva respuesta a tu pregunta')
            ->line("{$this->message['lawyer_id']} ha respondido a tu pregunta.")
            ->action('Ver respuesta', url("/questions/{$this->message['pregunta_id']}"))
            ->line('Gracias por usar nuestra plataforma.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message['message'], // Mensaje de la notificación
            'question_id' => $this->message['pregunta_id'], // ID de la pregunta
            'lawyer_id' => $this->message['answerer_name'], // Nombre del abogado
        ];
    }
}
