<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{   
   public function login(Request $request)
{
    // Validamos la entrada
    $credenciales = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // Buscamos el usuario por email
    $user = User::where('email', $request->email)->first();

    // Verificamos que el usuario exista y la contraseña coincida
    if (!$user || !Hash::check($request->password, $user->password_hash)) {
        return response()->json([
            'message' => 'El login es incorrecto'
        ], 401);
    }

    // Usuario válido, creamos el token
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user,
    ]);
}

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Se ha cerrado la sesión exitosamente'
        ]);
    }
}