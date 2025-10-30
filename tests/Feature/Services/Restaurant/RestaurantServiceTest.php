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

     $this->userNotOwner = User::factory()->create([
        'name' => 'Renato',
        'email' => 'renato@teste.com',
        'password' => 'Teste123',
    ]);

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

    $this->actingAs($this->user);
});

function makeService(): RestaurantService {
    return app(RestaurantService::class);
}

it('should create a new restaurant', function () {

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

    $restaurant = $service->storeRestaurant($data);

    expect($restaurant)->toBeInstanceOf(\App\Models\Restaurant::class)
                       ->and($restaurant->name)->toBe('Restaurante Teste');
});

it('should get all restaurants for perfil admin master', function () {
    $restaurant = Restaurant::factory()->create([
        'address_id' => $this->address->id,
    ]);

    $this->user->assignRole(Role::create(['name' => RoleEnum::ADMIM_MASTER->value, 'guard_name' => 'api']));

    $restaurant->users()->syncWithoutDetaching($this->user->id);

    $service = makeService();
    $result = $service->getAll();

    expect($result->first()->id)->toBe($restaurant->id);
});

it('should get restaurants for perfil admin restaurant', function () {
    $restaurant = Restaurant::factory()->create([
        'address_id' => $this->address->id,
    ]);

    $this->user->assignRole(Role::create(['name' => RoleEnum::ADMIN_RESTAURANT->value, 'guard_name' => 'api']));

    $restaurant->users()->syncWithoutDetaching($this->user->id);

    $service = makeService();
    $result = $service->get($restaurant->id);

    expect($result->first()->id)->toBe($restaurant->id);
    
});

it('should exception for user not owner restaurant', function () {
    
    $restaurant = Restaurant::factory()->create([
        'address_id' => $this->address->id,
    ]);

    $this->user->assignRole(Role::create(['name'=> RoleEnum::ADMIN_RESTAURANT->value, 'guard_name' => 'api']));

    $restaurant->users()->syncWithoutDetaching($this->userNotOwner->id);
    
    $service = makeService();

    $this->expectException(AuthorizationException::class);

    $service->get($restaurant->id);

});

it('should get a restaurant by ID', function () {
    $restaurant = Restaurant::factory()->create([
        'address_id' => $this->address->id,
    ]);

    $this->user->assignRole(Role::create(['name' => RoleEnum::ADMIM_MASTER->value, 'guard_name' => 'api']));

    $service = makeService();
    $result = $service->get($restaurant->id);

    expect($result->id)->toBe($restaurant->id);
});

it('should update a restaurant admin master', function () {    
    $restaurant = Restaurant::factory()->create([
        'address_id' => $this->address->id,
    ]);

    $this->user->assignRole(Role::create(['name' => RoleEnum::ADMIM_MASTER->value, 'guard_name' => 'api']));

    $restaurant->users()->syncWithoutDetaching($this->user->id);

    $service = makeService();

    $data = [
        'id' => $restaurant->id,
        'name'=> 'Restaurante Teste 2',
        'slug' => 'restaurante-teste-2',
    ];

    $update = $service->update($data);

    expect($update->name)->toBe('Restaurante Teste 2');
    
});

it('should update a restaurant admin restaurant is owner', function () {
    $restaurant = Restaurant::factory()->create([
        'address_id' => $this->address->id,
    ]);

    $this->user->assignRole(Role::create(['name' => RoleEnum::ADMIN_RESTAURANT->value, 'guard_name' => 'api']));

    $restaurant->users()->syncWithoutDetaching($this->user->id);

    $service = makeService();

    $data = [
        'id'=> $restaurant->id,
        'name'=> 'Restaurante Teste 2',
        'slug' => 'restaurante-teste-2',
    ];

    $update = $service->update($data);

    expect($update->name)->toBe('Restaurante Teste 2');
    
});

it('should exception update for user not owner restaurant', function () {
    Restaurant::factory()->create([
        'address_id' => $this->address->id,
    ]);

    $this->user->assignRole(Role::create(['name'=> RoleEnum::ADMIN_RESTAURANT->value, 'guard_name' => 'api']));
    
    $service = makeService();

    $this->expectException(SistemException::class);
    $service->update([]);
});

it('should destroy a restaurant', function () {
    $restaurant = Restaurant::factory()->create([
        'address_id' => $this->address->id,
    ]);

    $this->user->assignRole(Role::create(['name' => RoleEnum::ADMIM_MASTER->value, 'guard_name' => 'api']));

    $service = makeService();

    $service->destroyRestaurant($restaurant->id);

    $restaurantDisabled = $service->get($restaurant->id);

    expect($restaurantDisabled->active)->toBe(0);
});


