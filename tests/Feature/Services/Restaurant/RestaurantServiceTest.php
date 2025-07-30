<?php

use App\Exceptions\Address\SistemException;
use App\Models\Address;
use App\Models\Profile;
use App\Models\User;
use App\Models\Restaurant;
use App\Services\Restaurant\RestaurantService;

beforeEach(function () {
    $this->profile = Profile::factory()->create([
        'type' => 'admin master',
        'active' => true,
    ]);

    $this->user = User::factory()->create([
        'name' => 'Luis Felipe',
        'email' => 'luis@teste.com',
        'password' => 'Teste123',
        'profile_id' => $this->profile->id,
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

    $this->actingAs($this->user); // já deixa autenticado
});

// helper para instanciar serviço com injeção real
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
    ];

    $restaurant = $service->storeRestaurant($data);

    expect($restaurant)->toBeInstanceOf(\App\Models\Restaurant::class)
                       ->and($restaurant->name)->toBe('Restaurante Teste');
});

it('returns the correct restaurant by ID', function () {
    $this->actingAs($this->user);

   $restaurant = Restaurant::factory()->create([
        'address_id' => $this->address->id,
    ]);

    $restaurant->users()->syncWithoutDetaching($this->user->id);

    $service = makeService();
    $result = $service->getRestaurantById($restaurant->id);

    expect($result->id)->toBe($restaurant->id);
});

it('throws an exception if the restaurant is not found', function () {
    $this->expectException(SistemException::class);

    $service = makeService();
    $service->getRestaurantById(9999);
});

it('should update a restaurant', function () {

    $restaurant = Restaurant::factory()->create([
        'address_id' => $this->address->id,
    ]);

    $service = makeService();

    $data = [
        'id' => $restaurant->id,
        'name' => 'Novo Nome',
    ];

    $updated = $service->update($data);

    expect($updated->name)->toBe('Novo Nome');
});

it('should returns all restaurants', function () {
    Restaurant::factory()->count(3)->create();

    $service = makeService();

    $all = $service->getRestaurants();

    expect($all)->toHaveCount(3);
});

it('should returns all restaurants by user', function () {

    $restaurant = Restaurant::factory()->create();
    $restaurantTwo = Restaurant::factory()->create();

    Restaurant::factory()->create(); // de outro usuário

    $this->user->restaurants()->attach($restaurant->id);
    $this->user->restaurants()->attach($restaurantTwo->id);

    $service = makeService();

    $restaurants = $service->getRestaurantByuser();

    expect($restaurants)->toHaveCount(2);
});
