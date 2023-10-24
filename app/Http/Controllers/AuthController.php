<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(AuthRequest $request)
    {
        $data = $request->except(['_token', 'remember']);

        if (Auth::attempt($data, $request->filled('remember'))) {
            session()->regenerate();
            return redirect()->intended('home');
        }

        return back()->withErrors([
            'email' => 'Dados de acesso incorretos'
        ]);
    }
}
