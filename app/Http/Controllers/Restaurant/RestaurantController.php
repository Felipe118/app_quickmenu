<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantRequest;
use App\Interfaces\Restaurant\RestaurantServiceInterface;

class RestaurantController extends Controller
{
    public function __construct(
        private RestaurantServiceInterface $restaurantService
    ){}
    /**
     * @OA\Post(
     *    path="/api/restaurant/store",
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
     * @OA\Post(
     *    path="/api/restaurant/update",
     *    tags={"Restaurant"},
     *    summary="Update restaurant",
     *    description="Update restaurant",
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

    public function update(RestaurantRequest $request)
    {
        return $this->restaurantService->update($request->all());
    }

    /**
     * @OA\Get(
     *    path="/api/restaurant/get/{id}",
     *    tags={"Restaurant"},
     *    summary="Get restaurant",
     *    description="Get restaurant",
     *    @OA\Parameter(
     *         description="ID do restaurante",
     *         in="path",
     *         name="id",
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

    public function get(int $id)
    {
        return $this->restaurantService->get($id);
    }

    /**
     * @OA\Get(
     *    path="/api/restaurant/get-all",
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
    public function getAll()
    {
        return $this->restaurantService->getAll();
    }

    /**
     * @OA\Patch(
     *    path="/api/restaurant/delete/{id}",
     *    tags={"Restaurant"},
     *    summary="Delete restaurant by id",
     *    description="Delete restaurant by id",
     *    @OA\Parameter(
     *         description="ID do restaurante",
     *         in="path",
     *         name="id",
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
    public function destroy(int $id)
    {
        $this->restaurantService->destroyRestaurant($id);

        return response()->json([
            'message' => 'Restaurante desativado com sucesso',
        ],200);
    }
}
