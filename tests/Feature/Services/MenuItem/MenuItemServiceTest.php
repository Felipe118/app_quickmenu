<?php

use App\Models\Menu;
use App\Models\MenuItems;
use App\Models\Categories;
use App\Models\Restaurant;
use App\Services\MenuItem\MenuItemService;

beforeEach(function () {
    $this->restaurant = Restaurant::factory()->create();
    $this->menu = Menu::create([
        'name' => 'Menu Teste',
        'description' => 'Menu Teste desc',
        'image' => null,
        'restaurant_id' => $this->restaurant->id,
        'active' => true,
        'qrcode_path' => 'qrcodes/teste.svg',
        'slug' => 'menu-teste',
    ]);
    $this->category = Categories::create([
        'name' => 'Categoria Teste',
        'description' => 'Cat desc',
        'active' => true,
        'restaurant_id' => $this->restaurant->id,
    ]);

    $this->menuItemService = app(MenuItemService::class);
});

it('should create a new menu item', function () {
    $payload = [
        'name' => 'Item 1',
        'description' => 'Descrição Item 1',
        'price' => 19.99,
        'menu_id' => $this->menu->id,
        'category_id' => $this->category->id,
        'image' => 'https://example.com/img.png',
    ];

    $this->menuItemService->store($payload);

    $this->assertDatabaseHas('menu_items', [
        'name' => 'Item 1',
        'price' => 19.99,
        'menu_id' => $this->menu->id,
        'category_id' => $this->category->id,
    ]);
});

it('should get menu item by id', function () {
    $item = MenuItems::create([
        'name' => 'Item Find',
        'price' => 10.00,
        'menu_id' => $this->menu->id,
        'category_id' => $this->category->id,
        'active' => true,
    ]);

    $found = $this->menuItemService->get($item);

    expect($found->id)->toBe($item->id)
        ->and($found->name)->toBe('Item Find');
});

it('should update a menu item', function () {
    $item = MenuItems::create([
        'name' => 'Item Update',
        'price' => 10.00,
        'menu_id' => $this->menu->id,
        'category_id' => $this->category->id,
    ]);

    $this->menuItemService->update($item, ['name' => 'Item Updated', 'price' => 12.50]);

    $item->refresh();
    expect($item->name)->toBe('Item Updated')
        ->and($item->price)->toBe(12.50);
});

it('should get all active menu items for restaurant', function () {
    MenuItems::create([
        'name' => 'Item A',
        'price' => 5.00,
        'menu_id' => $this->menu->id,
        'category_id' => $this->category->id,
    ]);

    MenuItems::create([
        'name' => 'Item B',
        'price' => 6.00,
        'menu_id' => $this->menu->id,
        'category_id' => $this->category->id,
    ]);

    $items = $this->menuItemService->getAll($this->restaurant->id);

    expect($items->count())->toBe(2);
});

it('should soft destroy menu item', function () {
    $item = MenuItems::create([
        'name' => 'Item Soft',
        'price' => 9.90,
        'menu_id' => $this->menu->id,
        'category_id' => $this->category->id,
    ]);

    $this->menuItemService->destroy($item);
    $item->refresh();

    expect($item->active)->toBeFalsy();
});

it('should delete menu item', function () {
    $item = MenuItems::create([
        'name' => 'Item Delete',
        'price' => 9.90,
        'menu_id' => $this->menu->id,
        'category_id' => $this->category->id,
    ]);

    $this->menuItemService->delete($item);

    $this->assertDatabaseMissing('menu_items', ['id' => $item->id]);
});
