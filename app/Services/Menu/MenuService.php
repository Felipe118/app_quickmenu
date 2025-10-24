<?php

namespace App\Services\Menu;

use App\Exceptions\SistemException;
use App\Helpers\SlugHelpers;
use App\Interfaces\Menu\MenuServiceInterface;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MenuService extends BaseService implements MenuServiceInterface
{
    public function __construct(
        private SlugHelpers $slugHelpers,
    ){}

    public function storeMenu(array $data): Menu
    {
        try{
            $slug = $this->slugHelpers->slugify($data['name']);
            $slug_restaurant = Restaurant::where('id', $data['restaurant_id'])->first();

            $slug_complete = $slug_restaurant->slug.'/'.$slug;
            
            $qrcode = $this->gerarQRcode($slug_complete);
            
            return Menu::create(
                [
                    "name"=> $data["name"],
                    "description" => $data["description"] ?? null,
                    "image"=> $data["image"] ?? null,
                    "restaurant_id" => $data["restaurant_id"],
                    "qrcode_path" => $qrcode,
                    "slug" => $slug
                ]
            );
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao salvar menu');
        }
    }

    public function updateMenu(array $data) :void
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
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(), $e->getCode());
        }
    }

    public function getMenu(int $restaurant_id, ?int $id): Menu|Collection
    {
        try{
            $user = Auth::user();
            $menu = null;

            if(is_null($id)){
                return Menu::where('restaurant_id', $restaurant_id)->get();
            }
        
            $menu = Menu::find($id);

            if(is_null($menu)){
                throw new SistemException('Menu não encontrado',404);
            }

            $this->ensureAdminMasterOrRestaurantOwner($user, $restaurant_id);

            return $menu;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(), $e->getCode());
        }
        
    }

    public function destroyMenu(int $restaurant_id,int $id): void
    {
        try{
            $user = Auth::user();

            $this->ensureAdminMasterOrRestaurantOwner($user, $restaurant_id);

            $menu = Menu::find($id);
            
            if(is_null($menu)){
                throw new SistemException('Menu não encontrado',404);
            }

            $menu->update(["active" => false]);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(), $e->getCode());
        }
    }

    public function deleteMenu(int $restaurant_id,int $id): void
    {
        try{
            $user = Auth::user();

            $this->ensureAdminMasterOrRestaurantOwner($user, $restaurant_id);

            $menu = Menu::find($id);

            if(is_null($menu)){
                throw new SistemException('Menu não encontrado',404);
            }

            $menu->delete();
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(), $e->getCode());
        }
    }

    private function gerarQRcode(string $slug): ?string
    {
        $rota = route('cardapio.show', $slug);

        $path = 'qrcodes/'.$slug.'.svg';

        Storage::put('qrcodes/'.$slug.'.svg', QrCode::format('svg')->size(300)->generate($rota));

        return $path;
    }

}