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
}