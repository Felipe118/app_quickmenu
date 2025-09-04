<?php

namespace App\Services\Restaurant;

use App\Interfaces\Menu\MenuServiceInterface;
use App\Models\Menu;

class MenuService implements MenuServiceInterface
{


    public function store(array $data): Menu
    {
        $menu = Menu::create($data);

        return $menu;
    }

}