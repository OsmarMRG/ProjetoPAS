<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ContaUtilizador;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        $user = ContaUtilizador::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
        }

        if (! Hash::check($request->password, $user->password_hash)) {
            return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
        }

        Auth::login($user);

        return redirect()->route('area.camaras');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('site.index');
    }
}
