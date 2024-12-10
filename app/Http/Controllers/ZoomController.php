<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Consulting;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Firebase\JWT\JWT;

class ZoomController extends Controller
{
    public function createMeeting($consultingId)
    {
        try {
            // Obtener la asesoría desde la base de datos
            $consulting = Consulting::findOrFail($consultingId);

            // Construir la fecha y hora de inicio en formato ISO 8601
            $startTime = Carbon::parse($consulting->date . ' ' . $consulting->time)->toAtomString();

            // Crear la reunión en Zoom
            $client = new Client();
            $response = $client->post('https://api.zoom.us/v2/users/me/meetings', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->generarTokenZoom(),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'topic' => 'Asesoría Legal',
                    'type' => 2, // Reunión programada
                    'start_time' => $startTime, // Fecha y hora combinada
                    'duration' => 30, // Duración fija o ajustable si es necesario
                    'settings' => [
                        'join_before_host' => true,
                        'mute_upon_entry' => true,
                    ],
                ],
            ]);

            // Procesar respuesta de Zoom
            $data = json_decode($response->getBody(), true);

            // Guardar el enlace en la base de datos
            $consulting->update(['zoom_url' => $data['join_url']]);

            return response()->json([
                'message' => 'Reunión de Zoom creada con éxito.',
                'zoom_url' => $data['join_url'],
                'consulting' => $consulting, // Opcional: para más contexto en la respuesta
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error("Error en la solicitud a Zoom: " . $e->getMessage());
            if ($e->hasResponse()) {
                Log::error('Respuesta de error de Zoom: ' . $e->getResponse()->getBody());
            }
            return response()->json(['error' => 'Error al crear la reunión de Zoom'], 500);
        }
    }

    // Método para generar el token JWT de Zoom
    private function generarTokenZoom()
    {
        $payload = [
            'iss' => env('ZOOM_API_KEY'), // Zoom API Key desde .env
            'exp' => time() + 3600, // Validez del token: 1 hora
        ];

        return JWT::encode($payload, env('ZOOM_API_SECRET'), 'HS256'); // Firma con la clave secreta
        
    }

    // Ruta para obtener el token JWT de Zoom
    public function getZoomJwtToken()
    {
        // Generar el token JWT de Zoom
        $zoomJwtToken = $this->generarTokenZoom();

        // Retornar el token JWT al frontend
        return response()->json(['zoomJwtToken' => $zoomJwtToken]);
    }

}
