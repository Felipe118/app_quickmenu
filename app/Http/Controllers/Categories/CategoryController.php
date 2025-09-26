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
