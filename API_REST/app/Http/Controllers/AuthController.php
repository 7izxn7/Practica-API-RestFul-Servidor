<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validamos los datos recibidos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Creamos el usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 3. Generamos un token de Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        // 4. Devolvemos la respuesta
        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user' => $user,
            'token' => $token,
        ], 201);
    }
    public function login(Request $request)
    {
        // 1. Validamos los datos recibidos
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // 2. Comprobamos las credenciales
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        // 3. Obtenemos el usuario autenticado
        $user = Auth::user();

        // 4. Generamos un token
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. Devolvemos la respuesta
        return response()->json([
            'message' => 'Inicio de sesión correcto',
            'user' => $user,
            'token' => $token,
        ], 200);
    }
    public function logout(Request $request)
    {
        // 1. Obtenemos el token actual del usuario
        $request->user()->currentAccessToken()->delete();

        // 2. Devolvemos una respuesta
        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ], 200);
    }
}