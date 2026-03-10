<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegisterController extends Controller
{
    // FORM REGISTER
    public function showRegister()
    {
        return view('auth.register');
    }

    // PROCESS REGISTER
    public function register(Request $request)
    {
        // VALIDASI
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // SIMPAN USER (ROLE FIX = 3)
        $user = User::create([
            'role_id' => 3, // USER
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
        ]);

        // AUTO LOGIN
        Auth::login($user);

        return redirect('/login')->with('success', 'Register berhasil!');
    }
}