<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code; // Variable para pasar datos al correo

    /**
     * Crear una nueva instancia del mailable.
     *
     * @param string $code
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Construir el mensaje.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Código de Recuperación de Contraseña')
                    ->view('emails.reset_password') // Vista del correo
                    ->with(['code' => $this->code]); // Pasar datos a la vista
    }
}
