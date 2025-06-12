<?php

use App\Interfaces\Address\AddressServiceInterface;
use App\Interfaces\Address\AddressRepositoryInterface;
use App\Repositories\Address\AddressRepository;
use App\Services\Address\AddressService;
use App\Models\Address;
use Mockery;

it("should be able to create an address service", function () {

    $address = Mockery::mock(Address::class);
    $addressRepository = Mockery::mock(AddressRepositoryInterface::class);
    $addressService = Mockery::mock(AddressServiceInterface::class);

    $data = [
        "address_name"=> "Rua 3 de maio Avenida",
        "quatrain"=> "Quadra 10",
        "number"=> "12",
        "complement"=> "Apt 203",
        "district"=> "Centro",
        "city"=>  "Sao Paulo",
        "state"=> "SP",
        "neighborhood"=> "Jardim das Flores",
        "cep"=>  "12345678",
    ];

   

    $dadosRetornados = $addressService
    ->shouldReceive("storeAddress")
    ->andReturn($data);

    expect($dadosRetornados)->toBe($data);

    //expect($addressService->storeAddress($data))->toBe($data);
});
