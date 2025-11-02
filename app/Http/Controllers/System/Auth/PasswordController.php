<?php

namespace App\Http\Controllers\System\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    use ApiResponse;
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email field is required',
            'email.exists' => 'This email not registered',
        ]);
        $user = User::whereEmail($request->email)->firstOrFail();
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::put('otp_' . $user->id, $otp, now()->addMinutes(10));
        Mail::to($user)->send(new SendOtpMail($otp));
        return $this->success('Your OTP send to your mail', 200);
    }
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required'
        ], [
            'email.required' => 'Email field is required',
            'email.exists' => 'This email not registered',
            'otp.required' => 'OTP code is required'
        ]);
        $user = User::whereEmail($request->email)->firstOrFail();
        $otp = Cache::get('otp_' . $user->id);
        if (!$otp || $otp != $request->otp) {
            return $this->error('OTP Invalid or Expired');
        }
        Cache::forget('otp' . $user->id);
        Cache::put('otp_verified_' . $user->id, true, now()->addMinutes(value: 10));
        return $this->success('OTP verified successfully', 200);
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => ['required', 'string', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],

        ], [
            'email.required' => 'Email field is required',
            'email.exists' => 'This email is not registered',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Passwords do not match',
        ]);
        $user = User::whereEmail($request->email)->firstOrFail();
        if (!Cache::has('otp_verified_' . $user->id)) {
            return $this->error('OTP not verified', 403);
        }
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        Cache::forget('otp_verified_' . $user->id);
        return $this->success('Password reset successfully', 200);
    }
}
