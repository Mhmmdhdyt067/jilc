<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login.index');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Login sukses
            return response()->json(['message' => 'Login berhasil']);
        }

        // Gagal login
        return response()->json(['message' => 'Username atau password salah'], 422);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function daftar(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required',
                'name' => 'required',
            ]);

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->password),
            ]);

            return response()->json(['message' => 'Login berhasil']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Daftar Gagal periksa kembali data Anda'], 422);
        }
    }
}
