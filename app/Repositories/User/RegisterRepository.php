<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Interfaces\User\RegisterRepositoryInterface;
use App\Models\User;

class RegisterRepository implements RegisterRepositoryInterface
{
    public function __construct(
        private User $user,
    ){}

    public function register(array $data) :User
    {
        return $this->user->create(
            [ 
                'name' => $data['name'],
                'email'=> $data['email'],
                'password'=> bcrypt($data['password']),
                'profile_id'=> $data['profile_id'] ?? 4,
            ]
        );
    }
}