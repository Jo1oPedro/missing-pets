<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

/**
 * @OA\Info(
 *   title="API missing-pets Swagger Documentation",
 *   version="1.0",
 *   contact={
 *     "email": "joao.pedreira@estudante.ufjf.br"
 *   }
 * )
 */
class RegisterController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"User Register"},
     *     summary="Register a new user",
     *     description="This endpoint register a new user in the database",
     *     operationId="Register",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"email","password","password_confirmation"},
     *                 @OA\Property(property="email", type="string", example="gabriel_nunes@example.org"),
     *                 @OA\Property(property="password", type="string", example="#sdasd$ssdaAA@"),
     *                 @OA\Property(property="password_confirmation", type="string", example="#sdasd$ssdaAA@")
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token generated",
     *     @OA\JsonContent(
     *         @OA\Property(
     *             property="data",
     *             type="object",
     *             required={"token", "token_type", "expires_in"},
     *             @OA\Property(
     *                 property="token",
     *                 type="string",
     *                 description="The access token"
     *             ),
     *             @OA\Property(
     *                 property="token_type",
     *                 type="string",
     *                 enum={"bearer"},
     *                 description="The type of token"
     *             ),
     *             @OA\Property(
     *                 property="expires_in",
     *                 type="integer",
     *                 description="The expiration time of the token in seconds"
     *             )
     *          )
     *      )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Incorrect credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The provided credentials are incorrect.")
     *         )
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {
        /** @var User $user */
        $user = User::create($request->validated());
        $token = $user->createToken(env('JWT_SECRET'))->plainTextToken;
        return response()->json([
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }
}
