<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PetPostRequest;
use App\Models\PetPost;
use Illuminate\Http\Request;

class PetPostController extends Controller
{
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
        return PetPost::paginate($perPage, ['*'], 'page', $pageNumber);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PetPostRequest $request)
    {
        $petPost = PetPost::create($request->post());
        return response()->json(['data' => $petPost], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
