<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    /**
     * Show forgot password form (input email)
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Request password reset - validate email and send OTP
     */
    public function requestPasswordReset(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem kami.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        try {
            $user = User::where('email', $validated['email'])->firstOrFail();

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
            Mail::to($validated['email'])->send(new SendOtpMail($otp, $user->username));

            // Store email in session for next step
            session(['password_reset_email' => $validated['email']]);

            return redirect()->route('verify-otp')
                ->with('success', 'Kode OTP telah dikirim ke email Anda. Silahkan periksa email.');
        } catch (\Exception $e) {
            \Log::error('Password reset request error: ' . $e->getMessage());
            throw ValidationException::withMessages([
                'email' => 'Terjadi kesalahan saat memproses permintaan. Silahkan coba lagi.',
            ]);
        }
    }

    /**
     * Show OTP verification form
     */
    public function showVerifyOtpForm()
    {
        $email = session('password_reset_email');
        
        if (!$email) {
            return redirect()->route('forgot-password')
                ->with('error', 'Silahkan mulai dari awal.');
        }

        return view('auth.verify-otp', ['email' => $email]);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'otp' => 'required|size:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus terdiri dari 6 digit.',
        ]);

        $email = session('password_reset_email');
        
        if (!$email) {
            return redirect()->route('forgot-password')
                ->with('error', 'Silahkan mulai dari awal.');
        }

        try {
            $otpRecord = PasswordResetOtp::where('email', $email)->first();

            if (!$otpRecord) {
                throw new \Exception('OTP tidak ditemukan.');
            }

            // Check if locked
            if ($otpRecord->isLocked()) {
                $otpRecord->delete();
                session()->forget('password_reset_email');
                
                return redirect()->route('forgot-password')
                    ->with('error', 'Percobaan terlalu banyak. Silahkan mulai dari awal.');
            }

            // Check if expired
            if (!$otpRecord->isValid()) {
                $otpRecord->delete();
                session()->forget('password_reset_email');
                
                return redirect()->route('forgot-password')
                    ->with('error', 'Kode OTP telah kadaluarsa. Silahkan mulai dari awal.');
            }

            // Check if OTP matches
            if ($otpRecord->otp !== $validated['otp']) {
                $otpRecord->increment('attempts');
                $remaining = 5 - $otpRecord->attempts;
                
                throw ValidationException::withMessages([
                    'otp' => "Kode OTP tidak sesuai. Sisa percobaan: {$remaining}",
                ]);
            }

            // OTP verified! Store email in session and delete OTP record
            $otpRecord->delete();
            session(['password_reset_verified' => true]);

            return redirect()->route('reset-password')
                ->with('success', 'Verifikasi berhasil. Silahkan buat password baru.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('OTP verification error: ' . $e->getMessage());
            
            return back()
                ->with('error', $e->getMessage())
                ->onlyInput('otp');
        }
    }

    /**
     * Show reset password form
     */
    public function showResetPasswordForm()
    {
        if (!session('password_reset_verified')) {
            return redirect()->route('forgot-password')
                ->with('error', 'Silahkan verifikasi OTP terlebih dahulu.');
        }

        $email = session('password_reset_email');
        
        return view('auth.reset-password', ['email' => $email]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        if (!session('password_reset_verified')) {
            return redirect()->route('forgot-password')
                ->with('error', 'Silahkan mulai dari awal.');
        }

        $email = session('password_reset_email');
        
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        try {
            $user = User::where('email', $email)->firstOrFail();
            
            // Update password using Hash::make
            $user->update([
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            ]);

            // Clear session
            session()->forget(['password_reset_email', 'password_reset_verified']);

            return redirect()->route('login')
                ->with('success', 'Password Anda telah berhasil direset. Silahkan login dengan password baru.');
        } catch (\Exception $e) {
            \Log::error('Password reset error: ' . $e->getMessage());
            
            return redirect()->route('forgot-password')
                ->with('error', 'Terjadi kesalahan. Silahkan coba lagi.');
        }
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        $email = session('password_reset_email');
        
        if (!$email) {
            return redirect()->route('forgot-password')
                ->with('error', 'Silahkan mulai dari awal.');
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
            Mail::to($email)->send(new SendOtpMail($otp, $user->username));

            return back()
                ->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            \Log::error('Resend OTP error: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Terjadi kesalahan saat mengirim ulang OTP.');
        }
    }
}
