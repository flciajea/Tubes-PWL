<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            // ======================
            // REDIRECT BERDASARKAN ROLE
            // ======================

            if ($user->role_id == 1) {
                return redirect('/admin/dashboard');
            }

            if ($user->role_id == 2) {
                return redirect('/organizer/dashboard');
            }

            return redirect('/user/dashboard'); // role_id = 3
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}