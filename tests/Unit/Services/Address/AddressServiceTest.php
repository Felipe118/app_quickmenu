<?php

use App\Exceptions\SistemException;
use App\Services\Address\AddressService;
use Mockery;

beforeEach(function () {
    $this->addressService = Mockery::mock(AddressService::class);
});

it('should throw SistemException when trying to create user and storeAddress fails', function () {
    $this->addressService->shouldReceive('storeAddress')
        ->once()
        ->andThrow(new SistemException());

    expect(fn () => $this->addressService->storeAddress([]))
        ->toThrow(SistemException::class);
});