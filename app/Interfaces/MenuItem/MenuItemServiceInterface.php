<?php

namespace App\Interfaces\MenuItem;

use App\Models\MenuItems;
use Illuminate\Database\Eloquent\Collection;

interface MenuItemServiceInterface
{
    public function store(array $data): void;
    public function update(array $data): void;
    public function get(int $id, int $restaurant_id): MenuItems;
    public function getAll(int $restaurant_id):Collection ;
    public function destroy(int $id, int $restaurant_id): void;
    public function delete(int $id, int $restaurant_id): void;
}