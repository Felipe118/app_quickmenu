<?php

namespace App\Services\Menu;

use App\Exceptions\SistemException;
use App\Helpers\SlugHelpers;
use App\Interfaces\Menu\MenuServiceInterface;
use App\Models\Menu;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MenuService extends BaseService implements MenuServiceInterface
{
    public function __construct(
        private SlugHelpers $slugHelpers,
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

    public function updateMenu(array $data): Menu
    {
        try{
            $menu = Menu::find($data["id"]);

            $user = Auth::user();

            $this->ensureAdminMasterOrRestaurantOwner($user, $data['restaurant_id']);

            $menu->name = $data["name"];
            $menu->description = $data["description"] ?? null;
            $menu->image = $data["image"] ?? null;
            $menu->slug = $this->slugHelpers->slugify($data[
                "name"
            ]);
            $menu->restaurant_id = $data["restaurant_id"];
            $menu->active = $data["active"] ?? true;
            $menu->save();

            return $menu;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(), $e->getCode());
        }
    }

}