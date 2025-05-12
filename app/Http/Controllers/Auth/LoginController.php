<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard')->with('success', 'Login realizado com sucesso!');
        }

        return back()->withErrors(['login' => 'Usuário ou senha incorretos.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logout realizado com sucesso!');
    }
}
