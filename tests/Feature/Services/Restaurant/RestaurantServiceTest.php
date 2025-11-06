<?php

use App\Enums\RoleEnum;
use App\Exceptions\SistemException;
use App\Models\Address;
use App\Models\User;
use App\Models\Restaurant;
use App\Services\Restaurant\RestaurantService;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\Permission\Models\Role;

beforeEach(function () {

    $this->user = User::factory()->create([
        'name' => 'Luis Felipe',
        'email' => 'luis@teste.com',
        'password' => 'Teste123',
    ]);

    // $this->userRestaurant = userAdmimRestaurant();

    // $this->userMaster = userAdmimMaster();

    // $this->userNotOwner = userUserNotOwnerRestaurant();

    $this->address = Address::factory()->create([
        'address_name' => 'Quadra 122 Rua 12 Lote 3',
        'neighborhood' => 'Mansões Odisseaia',
        'quatrain' => 'QA22',
        'number' => '22',
        'complement' => 'Apt 200',
        'district' => 'Rua 3',
        'city' => 'Águas Lindas',
        'state' => 'GO',
        'cep' => '72735888',
    ]);

    $this->address2 = Address::factory()->create([
        'address_name' => 'Quadra 133 Rua 22 Lote 3',
        'neighborhood' => 'Mansões Odisseaia',
        'quatrain' => 'QA22',
        'number' => '22',
        'complement' => 'Apt 200',
        'district' => 'Rua 22',
        'city' => 'Águas Lindas',
        'state' => 'GO',
        'cep' => '72735888',
    ]);
});

function makeService(): RestaurantService {
    return app(RestaurantService::class);
}

it('should create a new restaurant', function () {

    // arrange
    userAdmimRestaurant();

    $service = makeService();

    $data = [
        'name' => 'Restaurante Teste',
        'perfil_img' => 'https://example.com/perfil.jpg',
        'capa_img' => 'https://example.com/capa.jpg',
        'open_time' => '11:00',
        'close_time'=> '15:00',
        'phone' => '61999999999',
        'email' => 'restaurante@email.com',
        'address_id' => $this->address->id,
        'slug' => 'restaurante-teste',
    ];

    // act
    $restaurant = $service->storeRestaurant($data);

    // assert
    expect($restaurant)->toBeInstanceOf(\App\Models\Restaurant::class)
                       ->and($restaurant->name)->toBe('Restaurante Teste');
});

it('should get all restaurants for perfil admin master', function () {

    // arrange
    $restaurant = Restaurant::factory()->create();
    $userAdmimMaster = userAdmimMaster();
    $service = makeService();
    

    // act
    $restaurant->users()->syncWithoutDetaching($userAdmimMaster->id);
    $result = $service->getAll();
    
   
    // assert
    expect($result->first()->id)->toBe($restaurant->id);
});

it('should get restaurants for perfil admin restaurant', function () {
    
    // arrange
    $restaurant = Restaurant::factory()->create([
        'address_id' => $this->address->id,
    ]);
    $userRestaurant = userAdmimRestaurant();
    $service = makeService();

    // act
    $restaurant->users()->syncWithoutDetaching($userRestaurant->id);
    $result = $service->get($restaurant->id);

    // assert
    expect($result->first()->id)->toBe($restaurant->id);
    
});

it('should exception for user not owner restaurant', function () {
    
    // arrange
    $restaurant = Restaurant::factory()->create();

    $userRestaurant = userAdmimMaster();

    $userRestaurantNotOwner = userNotOwnerRestaurant();


    // act
    $restaurant->users()->syncWithoutDetaching($userRestaurant->id);
   
    // assert
    expect($restaurant->users->contains($userRestaurant->id))->toBeTrue();
    expect($restaurant->users->contains($userRestaurantNotOwner->id))->toBeFalse();
});

it('should get a restaurant by ID', function () {

    // arrange
    $userRestaurant = userAdmimRestaurant();

    $restaurant = Restaurant::factory()->create();

    $service = makeService();

    //act
    $restaurant->users()->syncWithoutDetaching($userRestaurant->id);

    $result = $service->get($restaurant->id);

    // assert
    expect($result->id)->toBe($restaurant->id);
});

it('should update a restaurant admin master', function () {    
    
    // arrange
    $userRestaurant = userAdmimRestaurant();
    $restaurant = Restaurant::factory()->create();
    $service = makeService();

    $data = [
        'id' => $restaurant->id,
        'name'=> 'Restaurante Teste 2',
        'slug' => 'restaurante-teste-2',
    ];


    // act
    $restaurant->users()->syncWithoutDetaching($userRestaurant->id);

    $update = $service->update($data);

    // assert
    expect($update->name)->toBe('Restaurante Teste 2');
});

it('should update a restaurant admin restaurant is owner', function () {

    // arrange
    $restaurant = Restaurant::factory()->create();
    $userRestaurant = userAdmimRestaurant();
    $service = makeService();

    $restaurant->users()->syncWithoutDetaching($userRestaurant->id);

    $data = [
        'id'=> $restaurant->id,
        'name'=> 'Restaurante Teste 2',
        'slug' => 'restaurante-teste-2',
    ];


    // act
    $update = $service->update($data);

    // assert
    expect($update->name)->toBe('Restaurante Teste 2');
    
});

it('should exception update for user not owner restaurant', function () {
    Restaurant::factory()->create();

    userNotOwnerRestaurant();

    $service = makeService();

    $this->expectException(SistemException::class);
    $service->update([]);
});

it('should destroy a restaurant', function () {

    // arrange
    $restaurant = Restaurant::factory()->create();

    $service = makeService();

    // act
    $service->destroyRestaurant($restaurant->id);


    // assert
    $this->assertDatabaseHas('restaurant', [
        'id' => $restaurant->id,
        'active' => false,
    ]);
});


