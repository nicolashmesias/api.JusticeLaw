<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\Lawyer;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'last_name' => 'required|max:50',
            'type_document_id' => 'required|max:10',
            'document_number' => 'required|max:10',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($this->emailExistsInAnyTable($request->email)) {
            return response()->json(['error' => 'El correo ya está registrado en el sistema.'], 400);
        }

        $user = new User;
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->type_document_id = $request->type_document_id;
        $user->document_number = $request->document_number;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json($user, 201);
    }
    // public function login()
    // {
    //     $credentials = request(['email', 'password']);
    //     if (! $token = auth()->attempt($credentials)) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }
    //     return $this->respondWithToken($token);
    // }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $authenticatedUser = null; // Usuario autenticado
        $role = null; // Rol del usuario

        // Verificar en cada tabla y autenticar
        if ($user = User::where('email', $credentials['email'])->first()) {
            if (JWTAuth::attempt($credentials)) {
                $authenticatedUser = $user;
                $role = 'user';
            }
        } elseif ($lawyer = Lawyer::where('email', $credentials['email'])->first()) {
            if (JWTAuth::attempt($credentials)) {
                $authenticatedUser = $lawyer;
                $role = 'lawyer';
            }
        } elseif ($administrator = Administrator::where('email', $credentials['email'])->first()) {
            if (JWTAuth::attempt($credentials)) {
                $authenticatedUser = $administrator;
                $role = 'admin';
            }
        }

        // Si no se encuentra en ninguna tabla o las credenciales son incorrectas
        if (!$authenticatedUser) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Generar el token para el usuario autenticado
        $customClaims = ['role' => $role];

        $token = JWTAuth::claims($customClaims)->fromUser($authenticatedUser);

        return response()->json([
            'access_token' => $token,
            'role' => $role,
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => [
                'id' => $authenticatedUser->id,
                'email' => $authenticatedUser->email,
                'name' => $authenticatedUser->name,
            ],
        ]);
    }


    public function me()
    {
        return response()->json(auth()->user());
    }
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }


    public function registerLawyer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'last_names' => 'required|max:50',
            'type_document_id' => 'required|max:10',
            'document_number' => 'required|max:10',
            'email' => 'required|max:255|unique:lawyers',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $lawyer = new Lawyer();
        $lawyer->name = $request->name;
        $lawyer->last_names = $request->last_names;
        $lawyer->type_document_id = $request->type_document_id;
        $lawyer->document_number = $request->document_number;
        $lawyer->email = $request->email;
        $lawyer->password = bcrypt($request->password);
        $lawyer->save();

        return response()->json($lawyer, 201);
    }

    private function emailExistsInAnyTable($email)
    {
        return User::where('email', $email)->exists() ||
            Lawyer::where('email', $email)->exists() ||
            Administrator::where('email', $email)->exists();
    }
}
