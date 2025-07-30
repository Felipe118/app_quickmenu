<?php

namespace App\Repositories\Address;

use App\Interfaces\Address\AddressRepositoryInterface;
use App\Models\Address;

class AddressRepository implements AddressRepositoryInterface
{
    public function __construct(
        public Address $address
    ){}
    public function storeAddress(array $data): Address
    {
        $address = $this->address->create($data);
        return $address;
    }

    public function updateAddress(int $id, array $data): Address
    {
        $address = $this->address->findOrFail($id);
        
        $address->update($data);
        
        return $address;
    }

    public function getAddressById(int $id): Address|null
    {
        return $this->address->find($id);
    }
}