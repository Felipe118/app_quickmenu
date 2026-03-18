<?php


namespace App\Interfaces\Restaurant;

use App\Models\Restaurant;
use Illuminate\Support\Arr;

interface RestaurantRepositoryInterface
{
    public function store(array $data, int $userId) :Restaurant;
    public function update(array $data) :Restaurant;
}