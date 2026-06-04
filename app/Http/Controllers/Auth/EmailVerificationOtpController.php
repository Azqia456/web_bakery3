<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\PasswordResetOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EmailVerificationOtpController extends Controller
{
    /**
     * Send OTP to user's email for verification
     */
    public function sendOtp(Request $request)
    {
        $user = $request->user();

        if ($user->email_verified_at) {
            return response()->json(['message' => 'Email sudah terverifikasi.'], 400);
        }

        $otp = str_pad((string) rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Save OTP to password_reset_otps table (reuse model)
        $expires = Carbon::now()->addMinutes(10);

        PasswordResetOtp::create([
            'id_user' => $user->id_user,
            'email' => $user->email,
            'otp' => $otp,
            'attempts' => 0,
            'expires_at' => $expires,
        ]);

        try {
            Mail::to($user->email)->send((new SendOtpMail($otp, $user->username))->subject('Kode OTP Verifikasi Email - Three D Bakery'));
        } catch (\Exception $e) {
            Log::error('Failed to send verification OTP: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengirim email OTP.'], 500);
        }

        return response()->json(['message' => 'Kode OTP telah dikirim ke email Anda.']);
    }

    /**
     * Verify OTP and mark email as verified
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $user = $request->user();
        $otpInput = $request->input('otp');

        $record = PasswordResetOtp::where('email', $user->email)
            ->where('otp', $otpInput)
            ->orderByDesc('id')
            ->first();

        if (! $record) {
            return response()->json(['message' => 'Kode OTP tidak valid.'], 400);
        }

        if (! $record->isValid()) {
            return response()->json(['message' => 'Kode OTP sudah kedaluwarsa.'], 400);
        }

        if ($record->isLocked()) {
            return response()->json(['message' => 'Terlalu banyak percobaan. OTP terkunci.'], 400);
        }

        // Mark email verified
        $user->email_verified_at = Carbon::now();
        $user->save();

        // Optionally delete OTPs for this email
        PasswordResetOtp::where('email', $user->email)->delete();

        return response()->json(['message' => 'Email berhasil diverifikasi.']);
    }
}
