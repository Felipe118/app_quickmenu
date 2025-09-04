<?php

namespace App\Services\Menu;

use App\Exceptions\Address\SistemException;
use App\Helpers\SlugHelpers;
use App\Interfaces\Menu\MenuServiceInterface;
use App\Models\Menu;
use Illuminate\Support\Facades\Log;

class MenuService implements MenuServiceInterface
{
    public function __construct(
        private SlugHelpers $slugHelpers
    ){}

    public function storeMenu(array $data): Menu
    {
        try{
            $menu = Menu::create(
                [
                    "name"=> $data["name"],
                    "description" => $data["description"] ?? null,
                    "image"=> $data["image"] ?? null,
                    "restaurant_id" => $data["restaurant_id"],
                    "slug" => $this->slugHelpers->slugify($data["name"])
                ]
            );

            return $menu;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao salvar menu');
        }
    }

}