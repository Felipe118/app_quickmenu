<?php

use App\Enums\MessageEnum;
use App\Enums\RoleEnum;
use App\Models\Address;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\User;
use App\Services\Menu\MenuService;
use Database\Factories\MenuFactory;
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

    $this->restaurant = Restaurant::factory()->create([
        "name" => 'Restaurante Teste',
        "perfil_img" => 'https://example.com/perfil.jpg',
        "capa_img" =>  'https://example.com/capa.jpg',
        "open_time" => '11:00',
        "close_time"=> '15:00',
        "phone" => '61999999999',
        "email" => 'restaurante@email.com',
        'address_id' => Address::factory(),
        'slug' => 'restaurante-teste',
    ]);


    $this->actingAs($this->user);
});

function instaceServiceMenu() : MenuService
{
    return app(MenuService::class);
}

it('should create a new menu', function () {
    $service = instaceServiceMenu();

    $menu = [
        'name'=> 'Menu Teste',
        'description'=> 'Menu Teste',
        'image'=> 'https://example.com/image.jpg',
        'restaurant_id' => $this->restaurant->id,
        'qrcode_path' => 'qrcodes/teste.svg',
        'active' => true,
        'slug'=>'menu-teste',
    ];

    $menu = $service->storeMenu($menu);

    expect($menu)->toBeInstanceOf(Menu::class)
        ->and($menu->name)->toBe('Menu Teste');
});

it('should update a menu for user admin restaurant', function () {
    $service = instaceServiceMenu();

    $menu =MenuFactory::new()->create([
        'name'=>'Menu Teste',
        'restaurant_id' => $this->restaurant->id,
        'qrcode_path' => 'qrcodes/teste.svg',
        'active' => true,
        'slug'=>'menu-teste',
    ]);

    $this->user->assignRole(Role::create(['name'=> RoleEnum::ADMIN_RESTAURANT->value, 'guard_name' => 'api']));

    $this->restaurant->users()->syncWithoutDetaching($this->user->id);

    $data = [
        'id' => $menu->id,
        'name'=> 'Menu Teste Update',
        'description'=> 'Menu Teste Update',
        'image'=> 'teste',
        'slug'=>'menu-teste-update',
        'restaurant_id' => $this->restaurant->id,
    ];

    $service->updateMenu($data);

    $this->assertDatabaseHas('menu', ['name' => 'Menu Teste Update']);
});

it('should update a menu for user admin master', function(){
    $service = instaceServiceMenu();

        $menu = MenuFactory::new()->create([
        'name'=> 'Menu Teste',
        'restaurant_id' => $this->restaurant->id,
        'qrcode_path' => 'qrcodes/teste.svg',
        'active' => true,
        'slug'=>'menu-teste',
    ]);

    $this->user->assignRole(Role::create(['name'=> RoleEnum::ADMIM_MASTER->value, 'guard_name' => 'api']));

    $this->restaurant->users()->syncWithoutDetaching($this->user->id);

    $data = [
        'id' => $menu->id,
        'name'=> 'Menu Teste Update',
        'description'=> 'Menu Teste Update',
        'image'=> 'teste',
        'slug'=>'menu-teste-update',
        'restaurant_id' => $this->restaurant->id,
    ];

    $service->updateMenu($data);

    $this->assertDatabaseHas('menu', ['name' => 'Menu Teste Update']);
});

it('should get menu for user admin restaurant owner ', function(){
    $service = instaceServiceMenu();
    
    $menu = MenuFactory::new()->create();

    $this->user->assignRole(Role::create(['name'=> RoleEnum::ADMIM_MASTER->value,''=> '']));
});