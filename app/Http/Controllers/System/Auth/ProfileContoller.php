<?php

namespace App\Http\Controllers\System\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SystemUpdateProfileRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileContoller extends Controller
{
    use ApiResponse;
    public function me()
    {
        $user = auth()->user();
        return $this->success('User profile', 200, $user);
    }
    public function updateProfile(SystemUpdateProfileRequest $request)
    {
        $user = auth()->user();
        
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }
        $user->update([
            ...$request->validated(),
            'password' => $password ?? $user->password
        ]);
        return $this->success('User updated successfully', 200, $user);
    }

}
