<?php

namespace App\Services\Address;

use App\Exceptions\SistemException;
use App\Interfaces\Address\AddressRepositoryInterface;
use App\Interfaces\Address\AddressServiceInterface;
use App\Models\Address;
use Illuminate\Support\Facades\Log;

class AddressService implements AddressServiceInterface
{
    public function __construct(
        public AddressRepositoryInterface $addressRepository    
    ){}

    public function store(array $data): Address
    {
        try {
            $address = $this->addressRepository->store($data);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new SistemException('Erro ao salvar endereço');
        }

        return $address;
    }

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return $this->addressRepository->index();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new SistemException('Erro ao buscar endereços');
        }
    }

    public function getAddressById(int $id): Address
    {
        $address = $this->addressRepository->getAddressById($id);

        if (!isset($address->id)) {
            throw new SistemException('Endereço não encontrado.', 404);
        }

        return $address;
    }

    public function update(int $id, array $data): Address
    {
        $address = $this->getAddressById($id);

        try {
            return $this->addressRepository->update($data, $address);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new SistemException('Erro ao atualizar endereço');
        }
    }


    public function delete(int $id): void
    {
        try {
            $this->addressRepository->delete($id);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new SistemException('Erro ao deletar endereço');
        }
    }
}