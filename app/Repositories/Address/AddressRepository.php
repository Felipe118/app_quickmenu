<?php

namespace App\Repositories\Address;

use App\Interfaces\Address\AddressRepositoryInterface;
use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

class AddressRepository implements AddressRepositoryInterface
{
    public function __construct(
        public Address $address
    ){}

    public function store(array $data): Address
    {
        return $this->address->create($data);
    }

    public function index(): Collection
    {
        return $this->address->all();
    }

    public function getAddressById(int $id): Address|null
    {
        return $this->address->find($id);
    }

    public function update(array $data, Address $address): Address
    {
        $address->update($data);
        return $address;
    }

    public function delete(int $id): void
    {
        $address = $this->address->findOrFail($id);
        $address->delete();
    }
}