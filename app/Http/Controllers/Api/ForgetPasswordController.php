<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Mail\ResetPasswordMail;

class ForgetPasswordController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        // Generar un código único de 6 dígitos
        $code = random_int(100000, 999999);

        // Guardar el código en el caché (15 minutos de expiración)
        Cache::put('password_reset_code_' . $request->email, $code, now()->addMinutes(15));

        // Enviar el código al correo del usuario
        Mail::to($request->email)->send(new ResetPasswordMail($code));

        return response()->json([
            'status' => 'success',
            'message' => 'El código de recuperación ha sido enviado a tu correo.'
        ]);
    }

    // Validar el código recibido
    public function validateCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
            'email' => ['required', 'email']
        ]);

        // Obtener el código almacenado
        $storedCode = Cache::get('password_reset_code_' . $request->email);

        if ($storedCode && $storedCode === $request->code) {
            // Código válido, eliminar del caché
            Cache::forget('password_reset_code_' . $request->email);

            return response()->json(['status' => 'success', 'message' => 'Código validado correctamente.']);
        }

        return response()->json(['status' => 'error', 'message' => 'El código ingresado no es válido o ha expirado.']);
    }
}
