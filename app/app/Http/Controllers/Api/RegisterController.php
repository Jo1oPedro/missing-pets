<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        /** @var User $user */
        $user = User::create($request->validated());
        $token = $user->createToken(env('SECRET'))->plainTextToken;
        return response()->json([
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
            ]
        ]);
    }
}
