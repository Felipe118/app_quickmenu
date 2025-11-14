<?php

namespace App\Services\User;

use App\Enums\RoleEnum;
use App\Interfaces\User\RegisterRepositoryInterface;
use App\Interfaces\User\RegisterServiceInterface;
use Illuminate\Support\Facades\Log;

class RegisterService implements RegisterServiceInterface
{
    public function __construct(
        public RegisterRepositoryInterface $registerRepository
    ){}
    public function register(array $data) 
    {
        try {

            $this->verifyPasswordConfirm($data["password"], $data["password_confirmation"]);

            if(isset($data["role"])) {
                //$this->validateRoleUser($data["role"]);

                $role = $this->verifyRoleUser($data["role"]);

                $user = $this->registerRepository->register($data);

                $user->assignRole($role);

                return $user;
            }

            $user = $this->registerRepository->register($data);

            $user->assignRole(RoleEnum::ADMIN_RESTAURANT->value);

            return $user;
             
        } catch (\Exception $e) {
            Log::error($e);
            throw new \RuntimeException($e->getMessage(), 500, $e);
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

    public function verifyPasswordConfirm($password, $passwordConfirm)
    {
        if($password !== $passwordConfirm) {
            throw new \RuntimeException('As senhas nao conferem', 401);
        }
    }

    private function validateRoleUser(int $role)
    {
         if ($role === 1) {
            throw new \RuntimeException('Acesso negado',403);
        }
    }
}