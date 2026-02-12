<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContaUtilizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string'],     // email ou username
            'password' => ['required', 'string'],
        ]);

        $user = ContaUtilizador::where('email', $data['login'])
            ->orWhere('username', $data['login'])
            ->first();

        if (!$user || !Hash::driver('bcrypt')->check($data['password'], $user->password_hash)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        if (Schema::hasColumn('contas_utilizador', 'status') && $user->status !== 'active') {
            return response()->json(['message' => 'Conta desactivada'], 403);
        }

        // opcional mas recomendado: apagar tokens antigos para não acumular lixo
        $user->tokens()->delete();

        $token = $user->createToken('android')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'user_id' => $user->user_id,
                'username' => $user->username,
                'email' => $user->email,
            ],
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user_id' => $request->user()->user_id,
            'username' => $request->user()->username,
            'email' => $request->user()->email,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout ok']);
    }
}
