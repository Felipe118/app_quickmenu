<?php

namespace App\Interfaces\Menu;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface MenuServiceInterface
{
    public function store(array $data): Menu;
    public function update(array $data, Menu $menu) :void;
    public function getMenu(Menu $menu, User $user): ?Menu;
    public function index(User $user): Collection;
    public function destroy(int $id):void;
    public function delete(int $id):void;
}