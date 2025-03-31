<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    //-- 5 minutos esta como um padrao secundário, para facilicar os testes pode ser usado o TOKEN_EXPIREIN
   

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        // -- Token com expiração de 5 minutos
        $expireInMinutes = (int) env('TOKEN_EXPIREIN', 5);
        $token = $user->createToken('auth_token', [], now()->addMinutes($expireInMinutes));

        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'expires_in' => ($expireInMinutes  * 60)
        ]);
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();

        // Revoga tokens antigos
        $user->tokens()->delete();

        // Gera novo token com nova expiração de 5 minutos
        $expireInMinutes = (int) env('TOKEN_EXPIREIN', 5);
        $token = $user->createToken('auth_token', [], now()->addMinutes($expireInMinutes));

        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'expires_in' => ($expireInMinutes  * 60)
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout efetuado com sucesso'], 200);
    }
}
