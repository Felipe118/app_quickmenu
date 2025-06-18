<?php

//Create test using pest php to test AddressService class

use App\Models\Address;
use App\Repositories\Address\AddressRepository;
use App\Services\Address\AddressService;

beforeEach(function () {
    $this->addressRepository = new AddressRepository(new Address());
    $this->addressService = new AddressService($this->addressRepository);
});


it('should create a new address', function () {
  

    $data = [
        "address_name" => "Rua 3 de maio Avenida",
        "quatrain" => "Quadra 10",
        "number" => "12",
        "complement" => "Apt 203",
        "district" => "Centro",
        "city" => "Sao Paulo",
        "state" => "SP",
        "neighborhood" => "Jardim das Flores",
        "cep" => "12345678",
    ];

    $address = $this->addressService->storeAddress($data);

    expect($address)->toBeInstanceOf(Address::class);
    expect($address->address_name)->toBe($data['address_name']);
    expect($address->quatrain)->toBe($data['quatrain']);
    expect($address->number)->toBe($data['number']);
    expect($address->complement)->toBe($data['complement']);
    expect($address->district)->toBe($data['district']);
    expect($address->city)->toBe($data['city']);
    expect($address->state)->toBe($data['state']);
    expect($address->neighborhood)->toBe($data['neighborhood']);
    expect($address->cep)->toBe($data['cep']);
});

test('should update an existing address', function () {
    $data = [
        "address_name" => "Rua 3 de maio Avenida",
        "quatrain" => "Quadra 10",
        "number" => "12",
        "complement" => "Apt 203",
        "district" => "Centro",
        "city" => "Sao Paulo",
        "state" => "SP",
        "neighborhood" => "Jardim das Flores",
        "cep" => "12345678",
    ];

    $address = $this->addressService->storeAddress($data);

    $updateData = [
        "address_name" => "Rua 3 de maio Avenida Updated",
    ];

    $updatedAddress =  $this->addressService->updateAddress($address->id, $updateData);

    expect($updatedAddress)->toBeInstanceOf(Address::class);
    expect($updatedAddress->address_name)->toBe($updateData['address_name']);
});


test('should delete an address', function () {
    $data = [
        "address_name" => "Rua 3 de maio Avenida",
        "quatrain" => "Quadra 10",
        "number" => "12",
        "complement" => "Apt 203",
        "district" => "Centro",
        "city" => "Sao Paulo",
        "state" => "SP",
        "neighborhood" => "Jardim das Flores",
        "cep" => "12345678",
    ];

    $address = $this->addressService->storeAddress($data);

    $deleted = $this->addressService->deleteAddress($address->id);

    expect($deleted)->toBe(true);
});
