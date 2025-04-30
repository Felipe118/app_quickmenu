<?php

namespace App\Interface\Address;

use App\Models\Address;

interface AddressServiceInterface
{
    public function storeAddress(array $data): Address;
}