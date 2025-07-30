<?php


namespace App\Interfaces\Restaurant;

use App\Models\Restaurant;
use Illuminate\Support\Arr;

interface RestaurantRepositoryInterface
{
    public function store(int $userId,array $data) :Restaurant;
    public function update(array $data) :Restaurant;
}