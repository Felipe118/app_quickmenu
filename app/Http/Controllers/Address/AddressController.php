<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Interfaces\Address\AddressServiceInterface;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AddressController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        public AddressServiceInterface $addressService
    )
    {}

    /**
     * @OA\Get(
     *     path="/api/addresses",
     *     tags={"Address"},
     *     summary="List all addresses",
     *     description="Retrieve list of all addresses",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="addresses", type="array", @OA\Items(ref="#/components/schemas/Address"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $addresses = $this->addressService->index();

        return response()->json(['addresses' => $addresses], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/addresses",
     *     tags={"Address"},
     *     summary="Create address",
     *     description="Store address",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Address")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Endereço registrado com sucesso"
     *     )
     * )
     */
    public function store(AddressRequest $request)
    {
        $this->addressService->store($request->all());

        return response()->json([
            'message' => 'Endereço registrado com sucesso',
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/addresses/{address}",
     *     tags={"Address"},
     *     summary="Get address by id",
     *     description="Retrieve a single address",
     *     @OA\Parameter(
     *         name="address",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Address")
     *     )
     * )
     */
    public function show(Address $address)
    {
        $this->authorize('view', $address);

        $address = $this->addressService->getAddressById($address->id);

        return response()->json(['address' => $address], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/addresses/{address}",
     *     tags={"Address"},
     *     summary="Update address",
     *     description="Update address data",
     *     @OA\Parameter(
     *         name="address",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Address")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Endereço atualizado com sucesso"
     *     )
     * )
     */
    public function update(AddressRequest $request, Address $address)
    {
        $this->authorize('update', $address);

        $this->addressService->update($address->id, $request->all());

        return response()->json([
            'message' => 'Endereço atualizado com sucesso'
        ], 200);
    }


    /**
     * @OA\Delete(
     *     path="/api/addresses/{address}",
     *     tags={"Address"},
     *     summary="Delete address",
     *     description="Permanently delete address",
     *     @OA\Parameter(
     *         name="address",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Endereço deletado com sucesso"
     *     )
     * )
     */
    public function delete(Address $address)
    {
        $this->authorize('delete', $address);

        $this->addressService->delete($address->id);

        return response()->json([
            'message' => 'Endereço deletado com sucesso'
        ], 200);
    }
}
