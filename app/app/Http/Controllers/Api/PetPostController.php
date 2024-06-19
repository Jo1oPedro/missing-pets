<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Messaging;
use App\DTO\PetPostDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\PetPostRequest;
use App\Models\PetPost;
use App\Services\ImageUploader;
use App\Services\PetPostImageUploader;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class PetPostController extends Controller
{
    public function __construct(
        private Messaging $messaging,
        private PetPostImageUploader $imageUploader
    ) {}

    /**
     * @OA\Get(
     *      path="/api/pet/posts",
     *      tags={"Pet posts"},
     *      summary="Get all pet posts paginated",
     *      description="This endpoint return all pet posts paginated",
     *      operationId="getPetPosts",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Page number (optional)",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              default="1"
     *          )
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="current_page",
     *                  type="string",
     *                  description="The current page paginated"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  description="The posts returned"
     *              ),
     *              @OA\Property(
     *                  property="first_page_url",
     *                  type="string",
     *                  description="The url from the first 15 posts"
     *              ),
     *              @OA\Property(
     *                  property="last_page",
     *                  type="string",
     *                  description="The number of the last page"
     *              ),
     *              @OA\Property(
     *                  property="last_page_url",
     *                  type="string",
     *                  description="The url from the last 15 posts"
     *              ),
     *              @OA\Property(
     *                   property="links",
     *                   type="object",
     *                   description="The url to the previous and next page"
     *              ),
     *              @OA\Property(
     *                   property="next_page_url",
     *                   type="string",
     *                   description="The url to the next page"
     *              ),
     *              @OA\Property(
     *                   property="per_page",
     *                   type="string",
     *                   description="The number of posts per page"
     *              ),
     *              @OA\Property(
     *                   property="prev_page_url",
     *                   type="string",
     *                   description="The url to the previous page"
     *              ),
     *              @OA\Property(
     *                   property="to",
     *                   type="string",
     *                   description="The url to the previous page"
     *              ),
     *              @OA\Property(
     *                   property="total",
     *                   type="string",
     *                   description="The url to the previous page"
     *              ),
     *          )
     *      )
     *  )
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->input('paginate', 15);
        $pageNumber = (int) $request->input('page', 1);
        return PetPost::with(["pet_post_images", "user"])->paginate($perPage, ['*'], 'page', $pageNumber);
    }

    /**
     * @OA\Post(
     *      path="/api/pet/posts",
     *      tags={"Pet posts"},
     *      summary="Register a new pet post",
     *      description="This endpoint register a new pet post",
     *      operationId="registerPetPost",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"user_id","name","coordinate_x","coordinate_y","breed","type","additional_info"},
     *                  @OA\Property(property="user_id", type="integer", example=1, description="User's id."),
     *                  @OA\Property(property="name", type="string", example=jack, description="Pet's name."),
     *                  @OA\Property(property="coordinate_x", type="integer", example=1),
     *                  @OA\Property(property="coordinate_y", type="integer", example=1),
     *                  @OA\Property(property="breed", type="string", example="#sdasd$ssdaAA@"),
     *                  @OA\Property(property="type", type="string", example="#sdasd$ssdaAA@"),
     *                  @OA\Property(property="additional_info", type="string", example="#sdasd$ssdaAA@")
     *              )
     *          ),
     *      ),
     *      @OA\Response(
     *          response="201",
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *              property="data",
     *              type="object",
     *              required={"user_id", "name", "coordinate_x", "coordinate_y", "breed", "type", "additional_info", "updated_at", "created_at", "id"},
     *              @OA\Property(
     *                  property="user_id",
     *                  type="integer",
     *                  description="The access User's id its vinculated"
     *              ),
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  description="The name of the pet"
     *              ),
     *              @OA\Property(
     *                  property="coordinate_x",
     *                  type="integer",
     *                  description="Coordenate x where the pet was last seen"
     *              ),
     *              @OA\Property(
     *                   property="coordinate_y",
     *                   type="integer",
     *                   description="Coordenate y where the pet was last seen"
     *               ),
     *              @OA\Property(
     *                   property="breed",
     *                   type="string",
     *                   description="Breed of the lost animal"
     *               ),
 *                 @OA\Property(
     *                  property="type",
     *                  type="string",
     *                  description=""
     *              ),
     *             @OA\Property(
     *                 property="additional_info",
     *                 type="string",
     *                 description="Additional info to help find the pet"
     *              ),
     *            @OA\Property(
     *                property="updated_at",
     *                type="string",
     *                description=""
     *              ),
     *            @OA\Property(
     *                property="created_at",
     *                type="string",
     *                description=""
     *              ),
     *            @OA\Property(
     *               property="id",
     *               type="integer",
     *               description=""
     *              ),
     *           )
     *          )
     *      )
     *  )
     */
    public function store(PetPostRequest $request)
    {
        $petPost = PetPost::create($request->post());
        $this->messaging->publishMessage($petPost->id, 'cadastroPost')->destruct();
        if($request->hasFile("pet_images")) {
            try {
                $this->imageUploader
                    ->uploadFiles(
                        $request->file("pet_images"),
                        new PetPostDTO(...$petPost->toArray())
                    );
            } catch (Exception $exception) {
                return response()->json(['error' => $exception->getMessage()], $exception->getCode());
            }
        }
        return response()->json(['data' => $petPost->load("pet_post_images")], 201);
    }

    /**
     * @OA\GET(
     *      path="/api/pet/posts/{id}",
     *      tags={"Pet posts"},
     *      summary="Register a new pet post",
     *      description="This endpoint register a new pet post",
     *      operationId="getSpecificPetPost",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           description="The ID of the pet post",
     *           @OA\Schema(type="integer")
     *       ),
     *      @OA\Response(
     *          response="201",
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *              property="data",
     *              type="object",
     *              required={"user_id", "coordinate_x", "coordinate_y", "breed", "type", "additional_info", "updated_at", "created_at", "id", "user"},
     *                  @OA\Property(
     *                      property="user_id",
     *                      type="integer",
     *                      description="The access User's id its vinculated"
     *                  ),
     *                  @OA\Property(
     *                      property="coordinate_x",
     *                      type="integer",
     *                      description="Coordenate x where the pet was last seen"
     *                  ),
     *                  @OA\Property(
     *                      property="coordinate_y",
     *                      type="integer",
     *                      description="Coordenate y where the pet was last seen"
     *                  ),
     *                  @OA\Property(
     *                      property="breed",
     *                      type="string",
     *                      description="Breed of the lost animal"
     *                  ),
     *                  @OA\Property(
     *                      property="type",
     *                      type="string",
     *                      description=""
     *                  ),
     *                  @OA\Property(
     *                      property="additional_info",
     *                      type="string",
     *                      description="Additional info to help find the pet"
     *                  ),
     *                  @OA\Property(
     *                      property="updated_at",
     *                      type="string",
     *                      description=""
     *                  ),
     *                  @OA\Property(
     *                      property="created_at",
     *                      type="string",
     *                      description=""
     *                  ),
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      description=""
     *                  ),
     *                  @OA\Property(
     *                      property="data",
     *                      type="object",
     *                      required={"id", "name", "email", "email_verified_at", "created_at", "updated_at"},
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          description=""
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          description=""
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string",
     *                          description=""
     *                      ),
     *                      @OA\Property(
     *                          property="email_verified_at",
     *                          type="string",
     *                          description=""
     *                      ),
     *                      @OA\Property(
     *                          property="created_at",
     *                          type="string",
     *                          description=""
     *                      ),
     *                      @OA\Property(
     *                          property="updated_at",
     *                          type="string",
     *                          description=""
     *                      ),
     *                  )
     *              )
     *          )
     *      )
     *  )
     */
    public function show(string $id)
    {
        $petPost = PetPost::with('user')->find($id);
        return response()->json(['data' => $petPost]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
