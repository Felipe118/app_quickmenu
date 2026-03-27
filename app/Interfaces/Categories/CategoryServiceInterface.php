<?php

namespace App\Interfaces\Categories;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface CategoryServiceInterface
{
    public function store(array $data):void;
    public function getCategory(Categories $category, User $user ):Categories;
    public function index(int $restaurant_id, User $user):Collection;
    public function update(Categories $categories,array $data):void;
    public function destroy(int $id):void;
    public function delete(int $id):void;
}