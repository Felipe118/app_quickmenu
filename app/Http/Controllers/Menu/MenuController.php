<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Interfaces\Menu\MenuServiceInterface;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        public MenuServiceInterface $menuService,
    )
    {}

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
        $this->menuService->store($request->all());

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
    public function update(MenuRequest $request, Menu $menu)
    {
        $this->authorize('update', $menu);

        $this->menuService->update($request->all(), $menu);

        return response()->json([
            'message' => 'Menu atualizado com sucesso',
        ], 201);

    }

    /**
     * @OA\Get(
     *     path="/api/menus/{id}",
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

    public function show(Menu $menu)
    {
        $this->authorize('view', $menu);

        $user = Auth::user();

        return $this->menuService->getMenu($menu, $user);
    }
    
    /**
     * @OA\Get(
     *     path="/api/menus",
     *     tags={"Menu"},
     *     summary="Get all menu",
     *     description="Get all menu",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de menus",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=3),
     *                 @OA\Property(property="name", type="string", example="Cardapio Teste"),
     *                 @OA\Property(property="description", type="string", example="Cardapio Teste"),
     *                 @OA\Property(property="image", type="string", example="Teste.jpg"),
     *                 @OA\Property(property="restaurant_id", type="integer", example=2),
     *                 @OA\Property(property="active", type="boolean", example=true),
     *                 @OA\Property(property="slug", type="string", example="cardapio-Teste"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-09T03:58:10.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-09T03:58:10.000000Z")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $this->authorize('viewAny', Menu::class);

        $user = Auth::user();
        
        return $this->menuService->index($user);
    }

    /**
     * @OA\PATCH(
     *     path="/api/menus/{id}",
     *     tags={"Menu"},
     *     summary="Destroy menu ",
     *     description="Desativar menu",
     *     @OA\Parameter(
     *         description="ID do Menu",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Menu desativado com sucesso"
     *     )
     * )
     */

    public function destroy(Menu $menu)
    {
        $this->authorize('delete', $menu);

        $this->menuService->destroy($menu->id);

        return response()->json([
            'message' => 'Menu desativado com sucesso',
        ], 200);
    }

     /**
     * @OA\DELETE(
     *     path="/api/menus/{id}",
     *     tags={"Menu"},
     *     summary="Delete menu ",
     *     description="Deletar menu",
     *     @OA\Parameter(
     *         description="ID do Menu",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Menu deletado com sucesso"
     *     )
     * )
     */
    public function delete(Menu $menu)
    {
         $this->menuService->delete($menu->id);

         return response()->json([
             'message' => 'Menu deletado com sucesso',
         ],200);
    }
}
