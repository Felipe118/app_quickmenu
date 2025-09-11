<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Interfaces\Menu\MenuServiceInterface;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct(
        public MenuServiceInterface $menuService,
    )
    {
        
    }
    /**
     * @OA\Post(
     *     path="/api/menu/store",
     *     tags={"Menu"},
     *     summary="Store menu",
     *     description="Store menu",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Menu 1"),
     *             @OA\Property(property="description", type="string", example="Menu 1"),
     *             @OA\Property(property="image", type="string", example="https://example.com/image.jpg"),
     *             @OA\Property(property="active", type="boolean", example=true, default=true),
     *             @OA\Property(property="restaurant_id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Menu registrado com sucesso"
     *     )
     * )
     **/
    public function store(MenuRequest $request)
    {
        $this->menuService->storeMenu($request->all());

        return response()->json([
            'message' => 'Menu registrado com sucesso',
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/menu/update",
     *     tags={"Menu"},
     *     summary="Update menu",
     *     description="Update menu",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Menu 1"),
     *             @OA\Property(property="description", type="string", example="Menu 1"),
     *             @OA\Property(property="image", type="string", example="https://example.com/image.jpg"),
     *             @OA\Property(property="active", type="boolean", example=true),
     *             @OA\Property(property="restaurant_id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Menu registrado com sucesso"
     *     )
     * )    
     */
    public function update(MenuRequest $request)
    {
        $this->menuService->updateMenu($request->all());

        return response()->json([
            'message' => 'Menu atualizado com sucesso',
        ], 201);

    }

    /**
     * @OA\Get(
     *     path="/api/menu/{id}",
     *     tags={"Menu"},
     *     summary="Get menu",
     *     description="Get menu",
     *     @OA\Parameter(
     *         description="ID do Restaurante",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *     ),
     *     @OA\Parameter(
     *         description="ID do Menu",
     *         in="query",
     *         name="id",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *       @OA\Response(
     *          response=200,
     *          description="Lista de menus",
     *              @OA\JsonContent(
     *                  type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=3),
     *                          @OA\Property(property="name", type="string", example="Cardapio Teste"),
     *                          @OA\Property(property="description", type="string", example="Cardapio Teste"),
     *                          @OA\Property(property="image", type="string", example="Teste.jpg"),
     *                          @OA\Property(property="restaurant_id", type="integer", example=2),
     *                          @OA\Property(property="active", type="boolean", example=true),
     *                          @OA\Property(property="slug", type="string", example="cardapio-Teste"),
     *                          @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-09T03:58:10.000000Z"),
     *                          @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-09T03:58:10.000000Z")
     *                      )
     *                  )
     *             )
     *  )
     */

    public function get(int $restaurant_id,?int $id = null)
    {
        return $this->menuService->getMenu($restaurant_id, $id);
    }
}
