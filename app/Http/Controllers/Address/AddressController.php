<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Interfaces\Address\AddressServiceInterface;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(
        public AddressServiceInterface $addressService
    )
    {}

    /**
     * @OA\Post(
     *    path="/api/address/store",
     *    tags={"Address"},
     *    summary="Store address",
     *    description="Store address",
     *    @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(property="address_name", type="string", example="Rua das Flores"),
     *              @OA\Property(property="quatrain", type="string", example="Quadra 10"),
     *              @OA\Property(property="city", type="string", example="São Paulo"),
     *              @OA\Property(property="state", type="string", example="SP"),
     *              @OA\Property(property="cep", type="string", example="12345-678"),
     *              @OA\Property(property="complement", type="string", example="Apto 101"),
     *              @OA\Property(property="district", type="string", example="Centro"),
     *              @OA\Property(property="neighborhood", type="string", example="Jardim das Flores"),
     *              @OA\Property(property="number", type="string", example="123"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Endereço registrado com sucesso"
     *     )
     * )
     */
    public function storeAddress(AddressRequest $request)
    {
        $this->addressService->storeAddress($request->all());
    
        return response()->json([
            'message' => 'Endereço registrado com sucesso',
        ], 201);
    }

    /**
     * @OA\Put(
     *    path="/api/address/update/{id}",
     *    operationId="updateAddress",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *    required=true,
     *     @OA\Schema(
     *         type="integer",
     *         example=1
     *     )
     *   ),
     *    tags={"Address"},
     *    summary="Store address",
     *    description="Store address",
     *    @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(property="address_name", type="string", example="Rua das Flores"),
     *              @OA\Property(property="quatrain", type="string", example="Quadra 10"),
     *              @OA\Property(property="city", type="string", example="São Paulo"),
     *              @OA\Property(property="state", type="string", example="SP"),
     *              @OA\Property(property="cep", type="string", example="12345-678"),
     *              @OA\Property(property="complement", type="string", example="Apto 101"),
     *              @OA\Property(property="district", type="string", example="Centro"),
     *              @OA\Property(property="neighborhood", type="string", example="Jardim das Flores"),
     *              @OA\Property(property="number", type="string", example="123"),
     *             @OA\Property(property="id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Endereço atualizado com sucesso"
     *     )
     * )
     */
    public function updateAddress(int $id, AddressRequest $request)
    {
        $this->addressService->updateAddress($id, $request->all());
        
        return response()->json([
            'message' => 'Endereço atualizado com sucesso'
        ], 200);
        
    }

  /**
 * @OA\Get(
 *    path="/api/address/get/{id}",
 *    operationId="getAddress",
 *    tags={"Address"},
 *    summary="Get address by id",
 *    description="Get address by id",
 *    @OA\Parameter(
 *        name="id",
 *        in="path",
 *        required=true,
 *        @OA\Schema(
 *            type="integer",
 *            example=1
 *        )
 *    ),
 *    @OA\Response(
 *        response=200,
 *        description="Address found",
 *        @OA\JsonContent(
 *            type="object",
 *            @OA\Property(
 *                property="address",
 *                type="object",
 *                @OA\Property(property="address_name", type="string", example="Rua das Flores"),
 *                @OA\Property(property="quatrain", type="string", example="Quadra 10"),
 *                @OA\Property(property="city", type="string", example="São Paulo"),
 *                @OA\Property(property="state", type="string", example="SP"),
 *                @OA\Property(property="cep", type="string", example="12345-678"),
 *                @OA\Property(property="complement", type="string", example="Apto 101"),
 *                @OA\Property(property="district", type="string", example="Centro"),
 *                @OA\Property(property="neighborhood", type="string", example="Jardim das Flores"),
 *                @OA\Property(property="number", type="string", example="123")
 *            )
 *        )
 *    )
 * )
 */

    public function getAddress(int $id)
    {
        return  response()->json([
            'address' => $this->addressService->getAddressById($id)
        ], 200);
    }

      /**
     * @OA\Delete(
     *    path="/api/address/delete/{id}",
     *    operationId="deleteAddress",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *    required=true,
     *     @OA\Schema(
     *         type="integer",
     *         example=1
     *     )
     *   ),
     *    tags={"Address"},
     *    summary="Delete address by id",
     *    description="Delete address by id",
     *    @OA\Response(
     *         response=200,
     *        description="Endereço deletado com sucesso"
     *    )
     * )
     */
    public function destroyAddress(int $id)
    {
        $this->addressService->deleteAddress($id);
        
        return response()->json([
            'message' => 'Endereço deletado com sucesso'
        ], 200);
    }
  
}
