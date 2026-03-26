<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantRequest;
use App\Interfaces\Restaurant\RestaurantServiceInterface;
use App\Models\Restaurant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RestaurantController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private RestaurantServiceInterface $restaurantService
    ){}

     /**
     * @OA\Get(
     *    path="/api/restaurants",
     *    tags={"Restaurant"},
     *    summary="Get all restaurants",
     *    description="Get all restaurants",
     *    @OA\Response(
     *         response=200,
     *         description="Restaurante encontrado",
     *         @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Restaurante 1"),
     *              @OA\Property(property="perfil_img", type="string", example="https://example.com/perfil.jpg"),
     *              @OA\Property(property="capa_img", type="string", example="https://example.com/capa.jpg"),
     *              @OA\Property(property="email", type="string", example="teste@example.com"),
     *              @OA\Property(property="open_time", type="string", example="10:00"),
     *              @OA\Property(property="close_time", type="string", example="22:00"),
     *              @OA\Property(property="phone", type="string", example="1234567890"),
     *              @OA\Property(property="address_id", type="integer", example=1),
     *         )
     *     )
     * )
     */
    public function index()
    {
        $this->authorize('viewAny', Restaurant::class);

        return $this->restaurantService->index(auth()->user());
    }

    /**
     * @OA\Post(
     *    path="/api/restaurants",
     *    tags={"Restaurant"},
     *    summary="Store restaurant",
     *    description="Store restaurant",
     *    @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Restaurante 1"),
     *              @OA\Property(property="perfil_img", type="string", example="https://example.com/perfil.jpg"),
     *              @OA\Property(property="capa_img", type="string", example="https://example.com/capa.jpg"),
     *              @OA\Property(property="email", type="string", example="teste@example.com"),
     *              @OA\Property(property="open_time", type="string", example="10:00"),
     *              @OA\Property(property="close_time", type="string", example="22:00"),
     *              @OA\Property(property="phone", type="string", example="1234567890"),
     *              @OA\Property(property="address_id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Restaurante registrado com sucesso"
     *     )
     * )
     */
    public function store(RestaurantRequest $request)
    {
        return $this->restaurantService->storeRestaurant($request->all());
    }

      /**
     * @OA\Put(
     *    path="/api/restaurants/{restaurant}",
     *    tags={"Restaurant"},
     *    summary="Update restaurant",
     *    description="Update restaurant",
     *    @OA\Parameter(
     *         description="ID do restaurante",
     *         in="path",
     *         name="restaurant",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *    @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Restaurante 1"),
     *              @OA\Property(property="perfil_img", type="string", example="https://example.com/perfil.jpg"),
     *              @OA\Property(property="capa_img", type="string", example="https://example.com/capa.jpg"),
     *              @OA\Property(property="email", type="string", example="teste@example.com"),
     *              @OA\Property(property="open_time", type="string", example="10:00"),
     *              @OA\Property(property="close_time", type="string", example="22:00"),
     *              @OA\Property(property="phone", type="string", example="1234567890"),
     *              @OA\Property(property="address_id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurante atualizado com sucesso"
     *     )
     * )
     */

    public function update(RestaurantRequest $request, Restaurant $restaurant) 
    {
        $this->authorize('update', $restaurant);
        return $this->restaurantService->update($request->all(), $restaurant);
    }

    /**
     * @OA\Get(
     *    path="/api/restaurants/{restaurant}",
     *    tags={"Restaurant"},
     *    summary="Get restaurant",
     *    description="Get restaurant",
     *    @OA\Parameter(
     *         description="ID do restaurante",
     *         in="path",
     *         name="restaurant",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurante encontrado",
     *         @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Restaurante 1"),
     *              @OA\Property(property="perfil_img", type="string", example="https://example.com/perfil.jpg"),
     *              @OA\Property(property="capa_img", type="string", example="https://example.com/capa.jpg"),
     *              @OA\Property(property="email", type="string", example="teste@example.com"),
     *              @OA\Property(property="open_time", type="string", example="10:00"),
     *              @OA\Property(property="close_time", type="string", example="22:00"),
     *              @OA\Property(property="phone", type="string", example="1234567890"),
     *              @OA\Property(property="address_id", type="integer", example=1),
     *         )
     *     )
     * )
     */

    public function show(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);

        return $this->restaurantService->get($restaurant, auth()->user());
    }

   

    /**
     * @OA\Delete(
     *    path="/api/restaurants/{restaurant}",
     *    tags={"Restaurant"},
     *    summary="Delete restaurant by id",
     *    description="Delete restaurant by id",
     *    @OA\Parameter(
     *         description="ID do restaurante",
     *         in="path",
     *         name="restaurant",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *        description="Restaurante deletado com sucesso"
     *    )
     * )
     */
    public function destroy(Restaurant $restaurant)
    {
        $this->authorize('delete', $restaurant);

        $this->restaurantService->destroyRestaurant($restaurant);

        return response()->json([
            'message' => 'Restaurante desativado com sucesso',
        ],200);
    }
}
