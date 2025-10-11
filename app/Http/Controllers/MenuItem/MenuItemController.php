<?php

namespace App\Http\Controllers\MenuItem;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuItemRequest;
use App\Interfaces\MenuItem\MenuItemServiceInterface;

class MenuItemController extends Controller
{
    public function __construct(
        public MenuItemServiceInterface $menuItemService
    ){}

    /**
     * @OA\Post(
     *     path="/api/menu-item/store",
     *     tags={"Menu Item"},
     *     summary="Store menu item",
     *     description="Store menu item",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Item 1"),
     *             @OA\Property(property="description", type="string", example="Item 1"),
     *             @OA\Property(property="img", type="string", example="https://example.com/image.jpg"),
     *             @OA\Property(property="price", type="number", example="10.99"),
     *             @OA\Property(property="category_id", type="integer", example=2),
     *             @OA\Property(property="menu_id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Item do menu registrado com sucesso"
     *     )
     * )
     */
    public function store(MenuItemRequest $request)
    {
        $this->menuItemService->store($request->all());

        return response()->json([
            'message' => 'Item do menu registrado com sucesso',
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/menu-item/update",
     *     tags={"Menu Item"},
     *     summary="Update menu item",
     *     description="Update menu item",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Item 1"),
     *             @OA\Property(property="description", type="string", example="Item 1"),
     *             @OA\Property(property="img", type="string", example="https://example.com/image.jpg"),
     *             @OA\Property(property="price", type="number", example="10.99"),
     *             @OA\Property(property="category_id", type="integer", example=2),
     *             @OA\Property(property="menu_id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Item do menu atualizado com sucesso"
     *     )
     * )
     */
    public function update(MenuItemRequest $request)
    {
        $this->menuItemService->update($request->all());
        return response()->json([
            'message' => 'Item do menu atualizado com sucesso',
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/menu-item/get/{id}/restaurant/{restaurant_id}",
     *     tags={"Menu Item"},
     *     summary="Get menu item",
     *     description="Get menu item",
     *     @OA\Parameter(
     *         description="ID do item do menu",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *     ),
     *     @OA\Parameter(
     *         description="ID do restaurante",
     *         in="path",
     *         name="restaurant_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *     @OA\Response(
     *          response=200, 
     *              @OA\JsonContent(
     *                  @OA\Property(property="name", type="string", example="Item 1"),
     *                  @OA\Property(property="description", type="string", example="Item 1"),
     *                  @OA\Property(property="img", type="string", example="https://example.com/image.jpg"),
     *                  @OA\Property(property="price", type="number", example="10.99"),
     *                  @OA\Property(property="category_id", type="integer", example=2),
     *                  @OA\Property(property="menu_id", type="integer", example=1),
     *              )
     *     )
     * )
     */
    public function get(int $id, int $restaurant_id)
    {
        return $this->menuItemService->get($id, $restaurant_id);
    }

    /**
     * @OA\Get(
     *     path="/api/menu-item/get-all/restaurant/{restaurant_id}",
     *     tags={"Menu Item"},
     *     summary="Get all menu item",
     *     description="Get all menu item",
     *     @OA\Parameter(
     *         description="ID do restaurante",
     *         in="path",
     *         name="restaurant_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *     @OA\Response(
     *          response=200, 
     *              @OA\JsonContent(
     *                  @OA\Property(property="name", type="string", example="Item 1"),
     *                  @OA\Property(property="description", type="string", example="Item 1"),
     *                  @OA\Property(property="img", type="string", example="https://example.com/image.jpg"),
     *                  @OA\Property(property="price", type="number", example="10.99"),
     *                  @OA\Property(property="category_id", type="integer", example=2),
     *                  @OA\Property(property="menu_id", type="integer", example=1),
     *              )    
     *     )    
     * )
     */
    public function getAll(int $restaurant_id)
    {
        return $this->menuItemService->getAll($restaurant_id);
    }

    /**
     * @OA\Patch(
     *     path="/api/menu-item/delete/{id}/restaurant/{restaurant_id}",
     *     tags={"Menu Item"},
     *     summary="Delete menu item",
     *     description="Delete menu item",
     *     @OA\Parameter(
     *         description="ID do item do menu",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *     ),
     *     @OA\Parameter(
     *         description="ID do menu item",
     *         in="path",
     *         name="restaurant_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *     @OA\Response(
     *          response=200, 
     *              @OA\JsonContent(
     *                  @OA\Property(property="name", type="string", example="Item 1"),
     *                  @OA\Property(property="description", type="string", example="Item 1"),
     *                  @OA\Property(property="img", type="string", example="https://example.com/image.jpg"),
     *                  @OA\Property(property="price", type="number", example="10.99"),
     *                  @OA\Property(property="category_id", type="integer", example=2),
     *                  @OA\Property(property="menu_id", type="integer", example=1),
     *              )
     *     )
     * )
     */
    public function destroy(int $id, int $restaurant_id)
    {
        $this->menuItemService->destroy($id, $restaurant_id);

        return response()->json([
            'message' => 'Item do menu desativado com sucesso',
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/menu-item/delete/{id}/restaurant/{restaurant_id}",
     *     tags={"Menu Item"},
     *     summary="Delete menu item",
     *     description="Delete menu item",
     *     @OA\Parameter(
     *         description="ID do item do menu",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *     ),
     *     @OA\Parameter(
     *         description="ID do menu item",
     *         in="path",
     *         name="restaurant_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Item do menu deletado com sucesso"
     *     )
     * )
     */

    public function delete(int $id, int $restaurant_id)
    {
        $this->menuItemService->delete($id, $restaurant_id);
        return response()->json([
            'message' => 'Item do menu deletado com sucesso',
        ], 200);
    }


    
}
