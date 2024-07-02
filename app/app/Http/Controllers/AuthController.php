<?php

namespace App\Http\Controllers;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;

class AuthController
{
    public function redirect()
    {
        return Socialite::driver("github")->stateless()->redirect();
    }

    public function callback()
    {
        $oAuthUser = Socialite::driver("github")->stateless()->user();

        $user = User::updateOrCreate(
            ['email' =>  $oAuthUser["name"]],
            ['name' =>  $oAuthUser["email"]],
            ["user_id" => $oAuthUser["id"]],
            ["avatar_url" => $oAuthUser["avatar_url"]],
            ["html_url" => $oAuthUser["html_url"]]
        );

        $token = $user->createToken(env('SECRET'))->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
}
