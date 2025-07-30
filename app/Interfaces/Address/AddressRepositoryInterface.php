<?php

namespace App\Interfaces\Address;

use App\Models\Address;

interface AddressRepositoryInterface
{
    public function storeAddress(array $data): Address;
    public function getAddressById(int $id): Address|null;
    public function updateAddress(int $id, array $data): Address;
}