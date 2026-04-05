<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::with('userRole.role')->where('id', Auth::user()->id)->first();
            $request->session()->put('roles', $user->userRole);

            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->with('failed', 'Gagal! Username atau password salah!');
    }

    public function login()
    {
        return view('welcome');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        $google = Socialite::driver('google')->user();
        $user = User::with('userRole.role')->where('email', $google->email)->first();
        if (!$user) return back()->with('failed', 'User tidak terdaftar!');

        Auth::login($user);
        $request->session()->put('roles', $user->userRole);

        return redirect('/dashboard');
    }
}
