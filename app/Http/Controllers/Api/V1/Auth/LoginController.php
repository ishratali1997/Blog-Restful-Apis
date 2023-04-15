<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->apiResponse(true, 'Invalid credentials', null, null, 422);
        }

        $user = User::query()->where('email', $request->email)->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successWithData([
            'token' => $token,
            'user' => new UserResource($user),
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->success('Logout Successfully');
    }
}
