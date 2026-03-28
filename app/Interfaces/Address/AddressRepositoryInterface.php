<?php

namespace App\Interfaces\Address;

use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

interface AddressRepositoryInterface
{
    public function store(array $data): Address;
    public function index(): Collection;
    public function getAddressById(int $id): Address|null;
    public function update(array $data, Address $address): Address;
    public function delete(int $id): void;
}