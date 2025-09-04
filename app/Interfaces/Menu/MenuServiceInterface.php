<?php

namespace App\Interfaces\Menu;

use App\Models\Menu;

interface MenuServiceInterface
{
    public function store(array $data): Menu;
}