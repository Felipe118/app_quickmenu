<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Interfaces\User\RegisterServiceInterface;

class RegisterController extends Controller
{
    public function __construct(
        public RegisterServiceInterface $registerService,
    ){}

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registrar usuário",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="João Silva"),
     *             @OA\Property(property="email", type="string", example="joao@email.com"),
     *             @OA\Property(property="password", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuário registrado com sucesso"
     *     )
     * )
     */

    public function register(UserRequest $request)
    {
        try{
            $this->registerService->register($request->all());
            return response()->json([
                'message' => 'Usuário registrado com sucesso',
            ], 201);
        }catch(\RuntimeException $e){
            return response()->json([
                'message' => $e->getMessage(),
                'error' =>  $e->getPrevious() ? $e->getPrevious()->getMessage() : null,
            ], 500);
        }
        
    }
}
