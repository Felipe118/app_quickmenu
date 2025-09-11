<?php

namespace App\Interfaces\Menu;

use App\Models\Menu;

interface MenuServiceInterface
{
    public function storeMenu(array $data): Menu;
    public function updateMenu(array $data): Menu;
}