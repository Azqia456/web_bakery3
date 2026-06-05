<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

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

        // Check if email exists
        $user = User::where('email', $credentials['email'])->first();

        if ($user && !$user->email_verified_at) {
            // Resend OTP and redirect to verification
            try {
                $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                PasswordResetOtp::where('email', $credentials['email'])->delete();
                PasswordResetOtp::create([
                    'id_user' => $user->id_user,
                    'email' => $credentials['email'],
                    'otp' => $otp,
                    'attempts' => 0,
                    'expires_at' => Carbon::now()->addMinutes(10),
                ]);
                Mail::to($credentials['email'])->send(
                    new SendOtpMail($otp, $user->username, 'Kode OTP Verifikasi Email - Three D Bakery', 'verification')
                );
                session(['register_verify_email' => $credentials['email']]);
            } catch (\Exception $e) {
                \Log::error('Login resend OTP error: ' . $e->getMessage());
            }

            return redirect()->route('register.verify')
                ->with('error', 'Email Anda belum diverifikasi. Silahkan verifikasi email terlebih dahulu.');
        }

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
        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pelanggan',
        ]);

        try {
            // Generate 6 digit OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Delete old OTP for this email
            PasswordResetOtp::where('email', $validated['email'])->delete();

            // Save OTP to database (valid for 10 minutes)
            PasswordResetOtp::create([
                'id_user' => $user->id_user,
                'email' => $validated['email'],
                'otp' => $otp,
                'attempts' => 0,
                'expires_at' => Carbon::now()->addMinutes(10),
            ]);

            // Send OTP via email
            Mail::to($validated['email'])->send(
                new SendOtpMail($otp, $user->username, 'Kode OTP Verifikasi Email - Three D Bakery', 'verification')
            );

            // Store email in session for verification
            session(['register_verify_email' => $validated['email']]);

            return redirect()->route('register.verify')
                ->with('success', 'Kode OTP telah dikirim ke email Anda. Silahkan verifikasi email untuk melanjutkan.');
        } catch (\Exception $e) {
            \Log::error('Registration OTP error: ' . $e->getMessage());

            return redirect()->route('login')
                ->with('success', 'Registrasi berhasil! Silahkan login dengan akun Anda.');
        }
    }

    /**
     * Show email verification OTP form after registration
     */
    public function showVerifyEmailRegistration()
    {
        $email = session('register_verify_email');

        if (!$email) {
            return redirect()->route('login')
                ->with('error', 'Silahkan daftar terlebih dahulu.');
        }

        return view('auth.verify-email-registration', ['email' => $email]);
    }

    /**
     * Verify OTP for registration email verification
     */
    public function verifyEmailRegistration(Request $request)
    {
        $validated = $request->validate([
            'otp' => 'required|size:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus terdiri dari 6 digit.',
        ]);

        $email = session('register_verify_email');

        if (!$email) {
            return redirect()->route('register')
                ->with('error', 'Silahkan daftar terlebih dahulu.');
        }

        try {
            $otpRecord = PasswordResetOtp::where('email', $email)->first();

            if (!$otpRecord) {
                throw new \Exception('OTP tidak ditemukan. Silahkan daftar ulang.');
            }

            // Check if locked
            if ($otpRecord->isLocked()) {
                $otpRecord->delete();
                session()->forget('register_verify_email');

                return redirect()->route('register')
                    ->with('error', 'Percobaan terlalu banyak. Silahkan daftar ulang.');
            }

            // Check if expired
            if (!$otpRecord->isValid()) {
                $otpRecord->delete();
                session()->forget('register_verify_email');

                return redirect()->route('register')
                    ->with('error', 'Kode OTP telah kadaluarsa. Silahkan daftar ulang.');
            }

            // Check if OTP matches
            if ($otpRecord->otp !== $validated['otp']) {
                $otpRecord->increment('attempts');
                $remaining = 5 - $otpRecord->attempts;

                throw ValidationException::withMessages([
                    'otp' => "Kode OTP tidak sesuai. Sisa percobaan: {$remaining}",
                ]);
            }

            // OTP verified! Mark email as verified
            $user = User::where('email', $email)->firstOrFail();
            $user->email_verified_at = Carbon::now();
            $user->save();

            // Delete OTP record and clear session
            $otpRecord->delete();
            session()->forget('register_verify_email');

            return redirect()->route('login')
                ->with('success', 'Email berhasil diverifikasi! Silahkan login dengan akun Anda.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Registration email verification error: ' . $e->getMessage());

            return back()
                ->with('error', $e->getMessage())
                ->onlyInput('otp');
        }
    }

    /**
     * Resend OTP for registration email verification
     */
    public function resendRegisterOtp(Request $request)
    {
        $email = session('register_verify_email');

        if (!$email) {
            return redirect()->route('register')
                ->with('error', 'Silahkan daftar terlebih dahulu.');
        }

        try {
            $user = User::where('email', $email)->firstOrFail();

            // Generate new OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Delete old OTP
            PasswordResetOtp::where('email', $email)->delete();

            // Save new OTP
            PasswordResetOtp::create([
                'id_user' => $user->id_user,
                'email' => $email,
                'otp' => $otp,
                'attempts' => 0,
                'expires_at' => Carbon::now()->addMinutes(10),
            ]);

            // Send OTP via email
            Mail::to($email)->send(
                new SendOtpMail($otp, $user->username, 'Kode OTP Verifikasi Email - Three D Bakery', 'verification')
            );

            return back()
                ->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            \Log::error('Resend register OTP error: ' . $e->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat mengirim ulang OTP.');
        }
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
