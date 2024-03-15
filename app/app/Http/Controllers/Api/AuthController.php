<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Info(
 *   title="API missing-pets Swagger Documentation",
 *   version="1.0",
 *   contact={
 *     "email": "joao.pedreira@estudante.ufjf.br"
 *   }
 * )
 * @OA\SecurityScheme(
 *  type="http",
 *  description="Acess token obtido na autenticação",
 *  name="Authorization",
 *  in="header",
 *  scheme="bearer",
 *  bearerFormat="JWT",
 *  securityScheme="bearerToken"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Sanctum Authentication"},
     *     summary="Get an authentication user token",
     *     description="This endpoint returns a new token user authentication for use on protected endpoints",
     *     operationId="login",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"email","password"},
     *                 @OA\Property(property="email", type="string", example="gabriel_nunes@example.org"),
     *                 @OA\Property(property="password", type="string", example="#sdasd$ssdaAA@")
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
    public function login(Request $request)
    {
        /** @var User $user */
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            abort(401, 'The provided credentials are incorrect.');
        }

        $token = $user->createToken(env('SECRET'))->plainTextToken;

        return response()->json([
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
            ]
        ]);
    }
}
