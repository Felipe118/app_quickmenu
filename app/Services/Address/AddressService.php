<?php

namespace App\Services\Address;

use App\Exceptions\Address\SistemException;
use App\Interfaces\Address\AddressRepositoryInterface;
use App\Interfaces\Address\AddressServiceInterface;
use App\Models\Address;
use Illuminate\Support\Facades\Log;

class AddressService implements AddressServiceInterface
{
    public function __construct(
        public AddressRepositoryInterface $addressRepository    
    ){}

    public function storeAddress(array $data): Address
    {
        try {
            $address = $this->addressRepository->storeAddress($data);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new SistemException('Erro ao salvar endereço');
        }

        return $address;
     
    }

    public function updateAddress(int $id, array $data): Address
    {

        $address = $this->addressRepository->updateAddress($id, $data);
        
        if(!isset($address->id)){
            throw new SistemException();
        }

        return $address;
    }

    public function getAddressById(int $id): Address
    {
        $address = $this->addressRepository->getAddressById($id);
        
        if(!isset($address->id)){
            throw new SistemException('Endereço não encontrado.', 404);
        }

        return $address;
    }

    public function deleteAddress(int $id): bool
    {
        $address = $this->addressRepository->getAddressById($id);

        return $address->delete();
    }
}