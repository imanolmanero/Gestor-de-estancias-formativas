<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{   
    public function login(Request $request){

        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();

        if (!Auth::attempt($credenciales)) {
            return response()->json([
                'message' => 'El login es incorrecto'
            ], 401);
        }
        $request->session()->regenerate();
        return response()->json(Auth::user());
       
       
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }
    public function logout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Se ha cerrado la sesion exitosamente']);
    }
}
