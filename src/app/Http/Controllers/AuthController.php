<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function submitRegister(Request $request)
    {
        $userCount = User::count();
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'isGlobalAdmin' => $userCount === 0,
        ]);

        return redirect()->route('login');
    }

    public function submitLogin(Request $request)
    {
       $request->validate([

      'email'=>'required|email',
      'password'=>'required'
       ]);

       $credentials = $request->only('email' , 'password');

       if(Auth::attempt($credentials)){
        $request->session()->regenerate();

       }
        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
