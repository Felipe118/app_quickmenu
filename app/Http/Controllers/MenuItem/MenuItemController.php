<?php

namespace App\Http\Controllers\MenuItem;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuItemRequest;
use App\Interfaces\MenuItem\MenuItemServiceInterface;
use App\Models\MenuItems;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class MenuItemController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        public MenuItemServiceInterface $menuItemService
    ){}

    /**
     * @OA\Post(
     *     path="/api/menu-items",
     *     tags={"Menu Item"},
     *     summary="Store menu item",
     *     description="Store menu item",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/MenuItem")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Item do menu registrado com sucesso"
     *     )
     * )
     */
    public function store(MenuItemRequest $request)
    {
        $this->authorize('create', MenuItems::class);

        $this->menuItemService->store($request->all());

        return response()->json([
            'message' => 'Item do menu registrado com sucesso',
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/menu-items/restaurant/{restaurant}",
     *     tags={"Menu Item"},
     *     summary="Get all menu items",
     *     description="Get all menu items for a restaurant",
     *     @OA\Parameter(
     *         description="ID do restaurante",
     *         in="path",
     *         name="restaurant",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Itens do menu encontrados",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/MenuItem"))
     *     )
     * )
     */
    public function index(Restaurant $restaurant)
    {
        $this->authorize('get', MenuItems::class);

        $user = Auth::user();

        return $this->menuItemService->index($user);
    }

    /**
     * @OA\Get(
     *     path="/api/menu-items/{menuItem}",
     *     tags={"Menu Item"},
     *     summary="Get menu item",
     *     description="Get menu item by id",
     *     @OA\Parameter(
     *         description="ID do item do menu",
     *         in="path",
     *         name="menuItem",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item do menu encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/MenuItem")
     *     )
     * )
     */
    public function show(MenuItems $menuItem)
    {
        $this->authorize('view', $menuItem);

        return $this->menuItemService->get($menuItem);
    }

    /**
     * @OA\Put(
     *     path="/api/menu-items/{menuItem}",
     *     tags={"Menu Item"},
     *     summary="Update menu item",
     *     description="Update menu item",
     *     @OA\Parameter(
     *         description="ID do item do menu",
     *         in="path",
     *         name="menuItem",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/MenuItem")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item do menu atualizado com sucesso"
     *     )
     * )
     */
    public function update(MenuItemRequest $request, MenuItems $menuItem)
    {
        $this->authorize('update', $menuItem);

        $this->menuItemService->update($menuItem, $request->all());

        return response()->json([
            'message' => 'Item do menu atualizado com sucesso',
        ], 200);
    }

    /**
     * @OA\Patch(
     *     path="/api/menu-items/{menuItem}",
     *     tags={"Menu Item"},
     *     summary="Soft delete menu item",
     *     description="Deactivate a menu item",
     *     @OA\Parameter(
     *         description="ID do item do menu",
     *         in="path",
     *         name="menuItem",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item do menu desativado com sucesso"
     *     )
     * )
     */
    public function destroy(MenuItems $menuItem)
    {
        $this->authorize('delete', $menuItem);

        $this->menuItemService->destroy($menuItem);

        return response()->json([
            'message' => 'Item do menu desativado com sucesso',
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/menu-items/{menuItem}",
     *     tags={"Menu Item"},
     *     summary="Delete menu item",
     *     description="Delete a menu item",
     *     @OA\Parameter(
     *         description="ID do item do menu",
     *         in="path",
     *         name="menuItem",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item do menu deletado com sucesso"
     *     )
     * )
     */
    public function delete(MenuItems $menuItem)
    {
        $this->authorize('delete', $menuItem);

        $this->menuItemService->delete($menuItem);

        return response()->json([
            'message' => 'Item do menu deletado com sucesso',
        ], 200);
    }
}

