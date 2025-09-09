<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;

class UserController extends Controller
{
    // Registro de usuario (opcional)
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validación fallida', 'mensaje' => $validator->errors()], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['mensaje' => 'Usuario creado correctamente', 'user' => $user], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al crear usuario', 'mensaje' => $e->getMessage()], 500);
        }
    }

    // Login de usuario
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // Usando directamente JWTAuth para generar token
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciales inválidas'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo crear el token', 'mensaje' => $e->getMessage()], 500);
        }

        return response()->json(['token' => $token]);
    }

    public function me(Request $request)
    {
        try {
            $token = $request->bearerToken();
            if (!$token) {
                return response()->json(['error' => 'Token no proporcionado'], 400);
            }

            $user = JWTAuth::authenticate($token);
            if (!$user) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            return response()->json($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token inválido o expirado', 'mensaje' => $e->getMessage()], 401);
        }
    }


    // Logout de usuario
    public function logout(Request $request)
    {
        try {
            // Invalida el token automáticamente desde la request
            JWTAuth::parseToken()->invalidate();

            return response()->json(['mensaje' => 'Sesión cerrada correctamente']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Error al cerrar sesión', 'mensaje' => $e->getMessage()], 500);
        }
    }
}
