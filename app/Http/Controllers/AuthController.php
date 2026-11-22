<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses login Admin dan Pembeli
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek email dan password
        if (Auth::attempt($credentials)) {

            // Membuat session baru
            $request->session()->regenerate();

            // Ambil akun yang berhasil login
            $user = Auth::user();

            // Jika Admin
            if ($user->role === 'admin') {
                return redirect()->route('products.index');
            }

            // Jika Pembeli
            if ($user->role === 'pembeli') {
                return redirect()->route('user.products.index');
            }

            // Jika role tidak dikenali
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Role akun tidak dikenali.',
                ]);
        }

        // Jika email atau password salah
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}