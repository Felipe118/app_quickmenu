<?php

namespace App\Services\Menu;

use App\Enums\MessageEnum;
use App\Enums\RoleEnum;
use App\Exceptions\SistemException;
use App\Helpers\SlugHelpers;
use App\Interfaces\Menu\MenuServiceInterface;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\User;
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

    public function store(array $data): Menu
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
            throw new SistemException(MessageEnum::ERRO_AO_SALVAR->value, 500);
        }
    }

    public function update(array $data, Menu $menu) :void
    {
        try{

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
            throw new SistemException($e->getMessage(), $e->getCode() ?? 500);
        }
    }

    public function index(User $user): Collection
    {
        try{
            return Menu::visibleTo($user)
                ->where('active', true)
                ->get();
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(), $e->getCode() ?? 500);
        }
    }

    public function getMenu(Menu $menu, User $user): Menu
    {
        try{
            $user = Auth::user();
            return Menu::visibleTo($user)
                ->where('active', true)
                ->where('id', $menu->id)
                ->first();
            
            $menu = Menu::find($id);

            if(is_null($menu)){
                throw new SistemException(MessageEnum::MENU_NAO_ENCONTRADO->value,404);
            }

            return $menu;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(), $e->getCode() ?? 500);
        }
    }

    public function destroy(int $id): void
    {
        try{
            $menu = Menu::find($id);
            
            if(is_null($menu)){
                throw new SistemException(MessageEnum::MENU_NAO_ENCONTRADO->value,404);
            }

            $menu->update(["active" => false]);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(), $e->getCode() ?? 500);
        }
    }

    public function delete(int $id): void
    {
        try{
            $menu = Menu::find($id);

            if(is_null($menu)){
                throw new SistemException(MessageEnum::MENU_NAO_ENCONTRADO->value,404);
            }

            $menu->delete();
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(), $e->getCode());
        }
    }

    protected function gerarQRcode(string $slug): ?string
    {
        $rota = route('cardapio.show', $slug);

        $path = 'qrcodes/'.$slug.'.svg';

        Storage::put('qrcodes/'.$slug.'.svg', QrCode::format('svg')->size(300)->generate($rota));

        return $path;
    }

}