<?php

namespace App\Interfaces\Menu;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Collection;

interface MenuServiceInterface
{
    public function storeMenu(array $data): Menu;
    public function updateMenu(array $data) :void;
    public function getMenu(
        int $restaurant_id,
        ?int $id
        ): Menu|Collection;

    public function destroyMenu(int $restaurant_id,int $id):void;
    public function deleteMenu(int $restaurant_id,int $id):void;
}