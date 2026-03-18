<?php

namespace App\Interfaces\Categories;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Collection;

interface CategoryServiceInterface
{
    public function store(array $data):void;
    public function getCategory(int $id_category, ?int $restaurant_id):Categories;
    public function getCategoryAdmin(int $id_category):Categories;
    public function getAll(?int $restaurant_id = null):Collection;
    public function update(array $data):void;
    public function destroy(int $id):void;
    public function delete(int $id_category,?int $id_restaurant = null):void;
}