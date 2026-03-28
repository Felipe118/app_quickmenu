<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Interfaces\Categories\CategoryServiceInterface;
use App\Models\Categories;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        public CategoryServiceInterface $categoryService
    ){}
    
    /**
     * @OA\Post(
     *     path="/api/categories",
     *     tags={"Category"},
     *     summary="Store category",
     *     description="Store category",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Category 1"),
     *             @OA\Property(property="description", type="string", example="Category 1"),
     *             @OA\Property(property="active", type="boolean", example=true, default=true),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoria registrado com sucesso"
     *     )     
     * )
     */
    public function store(Request $request)
    {
        $this->categoryService->store($request->all());

        return response()->json([
            'message' => 'Categoria registrada com sucesso',
        ], 201);

    }

    /** 
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     tags={"Category"},
     *     summary="Get category",
     *     description="Get category",
     *     @OA\Parameter(
     *         description="ID da categoria",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *     ),
     *     @OA\Response(
     *          response=200, 
     *          description="Restaurante encontrado",
     *              @OA\JsonContent(
     *                  @OA\Property(property="name", type="string", example="Category 1"),
     *                  @OA\Property(property="description", type="string", example="Category 1"),
     *                  @OA\Property(property="active", type="boolean", example=true),
     *                  @OA\Property(property="restaurant_id", type="integer", example=1),
     *               )
     * 
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoria não encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoria não encontrada")  
     *         )
     *     )
     * )
     * 
     */
    public function show(Categories $categories)
    {
        $this->authorize('view', $categories);

        $user = Auth::user();

        return $this->categoryService->getCategory($categories, $user);
    }

    /**
     *     @OA\Get(
     *     path="/api/restaurants/{restaurant}/categories",
     *     tags={"Category"},
     *     summary="Get all categories by restaurant",
     *     description="Get all categories by restaurant",
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
     *          description="Categorias encontradas",
     *          @OA\JsonContent(
     *               type="array",
     *               @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="name", type="string", example="Category 1"),
     *                  @OA\Property(property="description", type="string", example="Category 1"),
     *                  @OA\Property(property="active", type="boolean", example=true),
     *                  @OA\Property(property="restaurant_id", type="integer", example=1),
     *               )
     *           )
     * 
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categorias não encontradas",
     *     ),
     * )
     */
    public function index(Restaurant $restaurant)
    {
        $this->authorize('get', Categories::class);

        $user = Auth::user();
        
        return $this->categoryService->index($restaurant->id, $user);
    }


    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     tags={"Category"},
     *     summary="Update category",
     *     description="Update category",
     *     @OA\Parameter(
     *         description="ID da categoria",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Category 1"),
     *             @OA\Property(property="description", type="string", example="Category 1"),
     *             @OA\Property(property="active", type="boolean", example=true),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoria atualizado com sucesso"
     *     )
     * )
     */
    public function update(Categories $categories,Request $request)
    {
        $this->authorize('update', $categories);

        $this->categoryService->update($categories,$request->all());

        return response()->json([
            'message' => 'Categoria atualizado com sucesso',
        ], 200);
    }

    /**
     * @OA\PATCH(
     *     path="/api/categories/{id}",
     *     tags={"Category"},
     *     summary="Destroy category",
     *     description="Destroy category",
     *     @OA\Parameter(
     *         description="ID da categoria",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria desativada com sucesso"
     *     )
     * )
     */
    public function destroy(Categories $categories)
    {
        $this->authorize('delete', $categories);

        $this->categoryService->destroy($categories->id);

        return response()->json([
            'message' => 'Categoria desativada com sucesso',
        ]);
    }

    /** 
     * @OA\DELETE(
     *     path="/api/categories/{id}",
     *     tags={"Category"},
     *     summary="Delete category",
     *     description="Delete category",
     *     @OA\Parameter(
     *         description="ID da categoria",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria deletada com sucesso"
     *     )     
     * )
    */
    public function delete(Categories $categories)
    {
        $this->authorize('delete', $categories);

        $this->categoryService->delete($categories->id);
        
        return response()->json([
            'message' => 'Categoria deletada com sucesso',
        ]);
    }

}
