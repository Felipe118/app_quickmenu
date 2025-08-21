<?php

namespace App\Services\User;

use App\Enums\RoleEnum;
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

            if($data["role"]) {
                //$this->validateRoleUser($data["role"]);
                $role = $this->verifyRoleUser($data["role"]);

                //dd($role);

                $user = $this->registerRepository->register($data);

                $user->assignRole($role);

                return $user;
            }
           
            $user = $this->registerRepository->register($data);

            return $user;
             
        } catch (\Exception $e) {
            throw new \RuntimeException('Erro ao registrar o usuário: ' . $e->getMessage(), 500, $e);
        }
    }

    private function verifyRoleUser(int $role)
    {
        switch ($role) {
            case 1:
                return RoleEnum::ADMIM_MASTER->value;
            case 2:
                return RoleEnum::ADMIN_RESTAURANT->value;
            case 3:
                return RoleEnum::USER_RESTAURANT->value;
            case 4:
                return RoleEnum::USER->value;
            default:
                throw new \RuntimeException("Role inválido", 401);
        }
    }

    private function validateRoleUser(int $role)
    {
         if ($role === 1) {
            throw new \RuntimeException('Acesso negado',403);
        }
    }
}