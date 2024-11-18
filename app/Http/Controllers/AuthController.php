<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Show register form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,kasir', // Validasi role
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Login langsung setelah registrasi
        Auth::login($user);

        // Arahkan ke dashboard berdasarkan role
        return $this->redirectTo();
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Arahkan ke dashboard berdasarkan role
            return $this->redirectTo();
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Redirect berdasarkan role setelah login
    protected function redirectTo()
    {
        if (Auth::user()->role === 'admin') {
            return redirect('/dashboard'); // Admin ke dashboard
        }

        return redirect('/transaksi'); // Kasir ke transaksi
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    
}


