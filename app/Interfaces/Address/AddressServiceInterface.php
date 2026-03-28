<?php

namespace App\Interfaces\Address;

use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

interface AddressServiceInterface
{
    public function store(array $data): Address;
    public function index(): Collection;
    public function getAddressById(int $id): Address;
    public function update(int $id, array $data): Address;
    public function delete(int $id): void;
}