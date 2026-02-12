<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CamarasApiController extends Controller
{
    public function minhas(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        $camaras = DB::table('camaras')
            ->join('user_camaras', 'camaras.id', '=', 'user_camaras.camera_id')
            ->where('user_camaras.user_id', $user->user_id)
            ->select('camaras.id', 'camaras.name', 'camaras.location')
            ->orderBy('camaras.id')
            ->get();

        return response()->json($camaras);
    }
}
