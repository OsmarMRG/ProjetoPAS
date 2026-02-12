<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Camera;

class AreaController extends Controller
{
    public function camaras()
    {
        $userId = Auth::user()->user_id;

        $camaras = Camera::orderBy('name')->get();

        $selecionadas = DB::table('user_camaras')
            ->where('user_id', $userId)
            ->pluck('camera_id')
            ->toArray();

        return view('area.camaras', [
            'camaras' => $camaras,
            'selecionadas' => $selecionadas,
        ]);
    }

    public function guardarCamaras(Request $request)
    {
        $userId = Auth::user()->user_id;

        $ids = $request->input('camaras', []);
        $ids = array_map('intval', $ids);

        DB::table('user_camaras')->where('user_id', $userId)->delete();

        $agora = now();
        $linhas = [];
        foreach ($ids as $cameraId) {
            $linhas[] = [
                'user_id' => $userId,
                'camera_id' => $cameraId,
                'created_at' => $agora,
                'updated_at' => $agora,
            ];
        }

        if (count($linhas) > 0) {
            DB::table('user_camaras')->insert($linhas);
        }

        return back()->with('ok', 'Câmaras guardadas');
    }
}
