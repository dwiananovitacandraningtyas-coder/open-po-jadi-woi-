<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    // Menampilkan halaman Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Memproses Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'pembeli',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('user.products.index')
            ->with('success', 'Registrasi berhasil! Selamat datang di SELUNÉ.');
    }

    // Logout Pembeli
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('user.products.index')
            ->with('success', 'Kamu berhasil logout.');
    }

    // Menampilkan halaman Akun Pembeli
    public function account()
    {
        return view('user.account');
    }
}