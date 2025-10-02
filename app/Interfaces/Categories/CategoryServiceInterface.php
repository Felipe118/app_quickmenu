<?php

namespace App\Interfaces\Categories;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Collection;

interface CategoryServiceInterface
{
    public function store(array $data):void;
    public function getCategory(int $id, int $restaurant_id):Categories;
    public function getAll(int $restaurant_id):Collection;
    public function update(array $data):void;
}