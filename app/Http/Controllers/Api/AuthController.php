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
    // public function     login()
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
        $authenticatedUser = null;
        $role = null;

        // Intentar autenticación con el guard 'user'
        if (Auth::guard('api')->attempt($credentials)) {
            $authenticatedUser = Auth::guard('api')->user();
            $role = 'user';
        }
        // Intentar autenticación con el guard 'lawyer'
        elseif (Auth::guard('lawyer')->attempt($credentials)) {
            $authenticatedUser = Auth::guard('lawyer')->user();
            $role = 'lawyer';
        }
        // Intentar autenticación con el guard 'administrator'
        elseif (Auth::guard('administrator')->attempt($credentials)) {
            $authenticatedUser = Auth::guard('administrator')->user();
            $role = 'admin';
        }

        // Si no se autenticó en ningún guard
        if (!$authenticatedUser) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        // Generar token con claims personalizados
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
        $guards = ['api', 'lawyer', 'administrator'];

        foreach ($guards as $guard) {
            if (auth($guard)->check()) {
                return response()->json(auth($guard)->user());
            }
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    // public function logout(Request $request)
    // {
    //     $token = $request->bearerToken();
    //     try {
    //         JWTAuth::invalidate($token);
    //         return response()->json(['message' => 'Successfully logged out'], 200);
    //     } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException $e) {
    //         return response()->json(['error' => 'Failed to logout, please try again'], 500);
    //     }
    // }




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
