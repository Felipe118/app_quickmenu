<?php

use App\Exceptions\Address\AddressErrorException;
use App\Services\Address\AddressService;
use Mockery;

beforeEach(function () {
    $this->addressService = Mockery::mock(AddressService::class);
});

it('should throw AddressErrorException when trying to create user and storeAddress fails', function () {
    $this->addressService->shouldReceive('storeAddress')
        ->once()
        ->andThrow(new AddressErrorException());

    expect(fn () => $this->addressService->storeAddress([]))
        ->toThrow(AddressErrorException::class);
});