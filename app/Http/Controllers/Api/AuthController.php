<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     // Autenticación del usuario
    //     if (Auth::attempt($credentials)) {
    //         // Obtener el usuario autenticado
    //         $user = Auth::user();
            
    //         // Crear token personal con Sanctum
    //         $token = $user->createToken('API Token')->plainTextToken;
            
    //         return response()->json([
    //             'token' => $token,
    //             'user' => $user,
    //         ], 200);
    //     }

    //     return response()->json(['message' => 'Unauthorized'], 401);
    // }

    // public function logout(Request $request)
    // {
    //     // Eliminar el token actual del usuario
    //     $request->user()->currentAccessToken()->delete();

    //     return response()->json(['message' => 'Logged out successfully'], 200);
    // }

    public function login(Request $request)
{

    $request->validate([
        'email' => '',
        'password' => '',
    ]);

    $credentials = $request->only('email', 'password');

    if (!$token = JWTAuth::attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    return $this->respondWithToken($token);
}


public function logout()
{
    JWTAuth::invalidate(JWTAuth::getToken());

    return response()->json(['message' => 'Successfully logged out']);
}


public function refresh()
{
    $token = JWTAuth::refresh(JWTAuth::getToken());
    return $this->respondWithToken($token);
}

public function me()
{
    return response()->json(Auth::user());
}


protected function respondWithToken($token)
{
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => JWTAuth::factory()->getTTL() * 60
    ]);
}

public function register(Request $request)
    {
        $request->validate([
        'name' => 'required|max:30',
            'last_name' => 'required|max:50',
            'type_document_id' => 'required|max:10',
            'document_number' => 'required|max:10',
            'email' => 'required|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'type_document_id' => $request->type_document_id,
            'document_number' => $request->document_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['user' => $user, 'token' => $token], 201);
    }


}