<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Interfaces\Categories\CategoryServiceInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        public CategoryServiceInterface $categoryService
    ){}
    
    /**
     * @OA\Post(
     *     path="/api/category/store",
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
     *     path="/api/category/get/{id}/restaurant/{restaurant_id}",
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
     *     ),
     * 
     * )
     */
    public function get(int $id, int $restaurant_id)
    {
       return $this->categoryService->getCategory($id,$restaurant_id);
    }

    /**
     *     @OA\Get(
     *     path="/api/category/getAll/{restaurant_id}",
     *     tags={"Category"},
     *     summary="Get all categories",
     *     description="Get all categories",
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
     *      
     *              @OA\JsonContent(
     *                  type="array",
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
     *     ),
     * )
     */
    public function getAll(int $restaurant_id)
    {
        return $this->categoryService->getAll($restaurant_id);
    }


    /**
     * @OA\Post(
     *     path="/api/category/update",
     *     tags={"Category"},
     *     summary="Update category",
     *     description="Update category",
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
    public function update(Request $request)
    {
        $this->categoryService->update($request->all());
    }

}
