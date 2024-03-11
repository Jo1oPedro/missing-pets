<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
     * @OA\POST(
     *  tags={"Sanctum Authentication"},
     *  summary="Get a autentication user token",
     *  description="This endpoints return a new token user authentication for use on protected endpoints",
     *  path="/api/login",
     *  @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              required={"email","password","device_name"},
     *              @OA\Property(property="email", type="string", example="gabriel_nunes@example.org"),
     *              @OA\Property(property="password", type="string", example="#sdasd$ssdaAA@"),
     *              @OA\Property(property="device_name", type="string", example="IOS"),
     *          )
     *      ),
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Token generated",
     *    @OA\JsonContent(
     *       @OA\Property(property="plainTextToken", type="string", example="2|MZEBxLy1zulPtND6brlf8GOPy57Q4DwYunlibXGj")
     *    )
     *  ),
     *  @OA\Response(
     *    response=401,
     *    description="Incorrect credentials",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The provided credentials are incorrect."),
     *       @OA\Property(property="errors", type="string", example="..."),
     *    )
     *  )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if(!$token = auth()->attempt($credentials)) {
            abort(401);
        }

        return response()->json([
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }
}
