<?php

namespace App\Interfaces\User;

use App\Models\User;

interface RegisterRepositoryInterface
{
    public function register(array $data) :User;
}