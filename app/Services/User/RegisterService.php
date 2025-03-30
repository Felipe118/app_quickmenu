<?php

namespace App\Services\User;

use App\Interfaces\User\RegisterRepositoryInterface;
use App\Interfaces\User\RegisterServiceInterface;

class RegisterService implements RegisterServiceInterface
{
    public function __construct(
        public RegisterRepositoryInterface $registerRepository
    ){}
    public function register(array $data) 
    {
        try {
            $user = $this->registerRepository->register($data);
            return $user; 
        } catch (\Exception $e) {
            throw new \RuntimeException('Erro ao registrar o usuário: ' . $e->getMessage(), 500, $e);
        }
    }
}