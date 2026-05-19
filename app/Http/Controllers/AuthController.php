<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private function redirectForRole(string $role)
    {
        return $role === 'owner'
            ? redirect()->route('dashboard')
            : redirect()->route('pelanggan.dashboard');
    }

    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectForRole(Auth::user()->role);
        }
        return view('login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Try to authenticate
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return $this->redirectForRole(Auth::user()->role);
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ])->onlyInput('email');
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectForRole(Auth::user()->role);
        }
        return view('register');
    }

    /**
     * Handle register request
     * Role otomatis menjadi "pelanggan" - user tidak bisa memilih role
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buat user baru dengan role otomatis "pelanggan"
        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pelanggan', // Role otomatis menjadi pelanggan
        ]);

        // Redirect ke login page - user harus login manual
        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silahkan login dengan akun Anda.');
    }

    /**
     * Handle logout
     * 
     * Logout dari sistem dengan benar:
     * - Clear authentication state
     * - Invalidate session
     * - Regenerate CSRF token
     * - Redirect ke login page
     */
    public function logout(Request $request)
    {
        try {
            // Capture user info BEFORE logout
            $userId = auth('web')->id();
            $username = auth('web')->user()?->username ?? 'unknown';
            
            // Clear authentication state
            Auth::logout();
            
            // Invalidate current session
            $request->session()->invalidate();
            
            // Regenerate CSRF token untuk keamanan
            $request->session()->regenerateToken();
            
            // Log logout activity (AFTER logout to ensure it's recorded)
            \Log::info('User logout successful', [
                'user_id' => $userId,
                'username' => $username,
                'timestamp' => now(),
                'ip_address' => $request->ip(),
            ]);
            
            // Redirect ke login dengan success message
            return redirect()->route('login')
                ->with('success', 'Anda telah logout. Terima kasih telah menggunakan sistem kami.');
        } catch (\Exception $e) {
            // Log any errors during logout
            \Log::error('Logout error', [
                'error' => $e->getMessage(),
                'user_id' => auth('web')->id() ?? 'unknown',
            ]);
            
            // Tetap logout meski ada error, redirect ke login
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')
                ->with('success', 'Anda telah logout.');
        }
    }
}
