<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ContaUtilizador;
use Illuminate\Support\Facades\Auth;

class ApiTokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token em falta'], 401);
        }

        $hashed = hash('sha256', $token);

        $row = DB::table('api_tokens')
            ->where('api_tokens.token', $hashed)
            ->select('api_tokens.user_id')
            ->first();

        if (!$row) {
            return response()->json(['message' => 'Token inválido'], 401);
        }

        $user = ContaUtilizador::where('user_id', $row->user_id)->first();
        if (!$user) {
            return response()->json(['message' => 'Utilizador não encontrado'], 401);
        }

        Auth::setUser($user);
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        // compatibilidade: disponibiliza o utilizador em atributos e em resolvers
        $request->attributes->set('api_user', $user);

        return $next($request);
    }
}
