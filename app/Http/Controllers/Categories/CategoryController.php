<?php

namespace App\Http\Controllers\Categories;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Interfaces\Categories\CategoryServiceInterface;
use Illuminate\Container\Attributes\Auth;
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
     *     path="/api/category/get/{id}",
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
    public function get(int $id_category, Request $request)
    {
        $user = auth()->user();
        
        if($user->hasRole(RoleEnum::ADMIM_MASTER->value)){
            return $this->categoryService->getCategoryAdmin($id_category);
        }
        $restaurant = $request->get('restaurant');
    
        return $this->categoryService->getCategory($id_category, $restaurant->id);
    }

    /**
     *     @OA\Get(
     *     path="/api/category/getAll",
     *     tags={"Category"},
     *     summary="Get all categories",
     *     description="Get all categories",
     *     @OA\Response(
     *          response=200, 
     *          description="Restaurante encontrado",
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
     *         description="Categoria não encontrada",
     *     ),
     * )
     */
    public function getAll(Request $request)
    {
        $user = auth()->user();
        
        if($user->hasRole(RoleEnum::ADMIM_MASTER->value)){
            return $this->categoryService->getAll();
        }

        $restaurant = $request->get('restaurant');

        return $this->categoryService->getAll($restaurant->id);
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

    /**
     * @OA\patch(
     *     path="/api/category/destroy/{id}",
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
    public function destroy(int $id)
    {
        $this->categoryService->destroy($id);
        return response()->json([
            'message' => 'Categoria desativada com sucesso',
        ]);
    }

    /** 
     * @OA\Delete(
     *     path="/api/category/delete/{id}",
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
    public function delete(Request $request, int $id)
    {
        $user = auth()->user();

        if($user->hasRole(RoleEnum::ADMIM_MASTER->value)){
            $this->categoryService->delete($id);

            return response()->json([
                'status' => 200,
                'message' => 'Categoria deletada com sucesso',
            ]);
        }

        $restaurant = $request->get('restaurant');

        $this->categoryService->delete($id, $restaurant->id);

        return response()->json([
            'status'=> 200,
            'message' => 'Categoria deletada com sucesso',
        ]);
    }

}
