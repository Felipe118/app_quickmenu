<?php

namespace App\Interfaces\MenuItem;

use App\Models\MenuItems;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
 
interface MenuItemServiceInterface
{
    public function store(array $data): void;
    public function update(MenuItems $menuItem, array $data): void;
    public function get(MenuItems $menuItem): MenuItems;
    public function index(User $user): Collection;
    public function destroy(MenuItems $menuItem): void;
    public function delete(MenuItems $menuItem): void;
}