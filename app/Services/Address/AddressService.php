<?php

namespace App\Services\Address;

use App\Exceptions\Address\AddressErrorException;
use App\Interfaces\Address\AddressRepositoryInterface;
use App\Interfaces\Address\AddressServiceInterface;
use App\Models\Address;

class AddressService implements AddressServiceInterface
{
    public function __construct(
        public AddressRepositoryInterface $addressRepository    
    ){}

    public function storeAddress(array $data): Address
    {
        $address = $this->addressRepository->storeAddress($data);
        
        if(!isset($address->id)){
            throw new AddressErrorException();
        }

        return $address;
     
    }

    public function updateAddress(int $id, array $data): Address
    {

        $address = $this->addressRepository->updateAddress($id, $data);
        
        if(!isset($address->id)){
            throw new AddressErrorException();
        }

        return $address;
    }

    public function getAddressById(int $id): Address
    {
        $address = $this->addressRepository->getAddressById($id);
        
        if(!isset($address->id)){
            throw new AddressErrorException('Endereço não encontrado.', 404);
        }

        return $address;
    }

    public function deleteAddress(int $id): bool
    {
        $address = $this->addressRepository->getAddressById($id);
        
        if(!isset($address->id)){
            throw new AddressErrorException('Endereço não encontrado.', 404);
        }

        return $address->delete();
    }
}