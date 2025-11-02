<?php

namespace App\Http\Controllers\System\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SystemLoginRequest;
use App\Http\Requests\Auth\SystemRegisterRequest;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Traits\ApiResponse;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(SystemRegisterRequest $request)
    {
        $user = User::create(
            [
                ...$request->validated(),
                'password' => Hash::make($request->password)
            ]
        );
        $token = $user->createToken('auth_token')->plainTextToken;
        Mail::to($user)->send(new WelcomeMail($user->name));
        return $this->success('User registerd successfully', 201, [
            'user' => $user,
            'token' => $token
        ]);
    }
    public function login(SystemLoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Email or password not valid');
        }
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->success('User logged in successfully', 200, [
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->success('Logged out successfully');
    }
}
