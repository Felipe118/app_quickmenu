<?php

namespace App\Interfaces\MenuItem;

use App\Models\MenuItems;
use Illuminate\Database\Eloquent\Collection;

interface MenuItemServiceInterface
{
    public function store(array $data): void;
    public function update(MenuItems $menuItem, array $data): void;
    public function get(MenuItems $menuItem): MenuItems;
    public function getAll(int $restaurant_id): Collection;
    public function destroy(MenuItems $menuItem): void;
    public function delete(MenuItems $menuItem): void;
}