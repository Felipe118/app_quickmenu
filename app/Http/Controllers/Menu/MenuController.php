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
}
