<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ZoomController extends Controller
{
    public function createMeeting(Request $request)
    {
        // Crear token JWT
        $key = env('ZOOM_API_KEY');
        $secret = env('ZOOM_API_SECRET');
        $payload = [
            'iss' => $key,
            'exp' => now()->addMinutes(30)->timestamp, // Token válido por 30 minutos
        ];

        $jwt = \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');

        // Configurar cliente HTTP
        $client = new Client([
            'base_uri' => 'https://api.zoom.us/v2/',
        ]);

        // Crear la reunión
        $response = $client->post('users/me/meetings', [
            'headers' => [
                'Authorization' => "Bearer $jwt",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'topic' => $request->topic ?? 'Asesoría Legal',
                'type' => 2, // Reunión programada
                'start_time' => $request->start_time, // Fecha y hora en formato ISO 8601
                'duration' => $request->duration, // Duración en minutos
                'settings' => [
                    'join_before_host' => true,
                    'waiting_room' => false,
                ],
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        // Retornar el enlace de la reunión
        return response()->json([
            'join_url' => $data['join_url'],
            'meeting_id' => $data['id'],
            'password' => $data['password'],
        ]);
    }
}
