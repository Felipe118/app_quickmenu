<?php

namespace App\Services\MenuItem;

use App\Exceptions\SistemException;
use App\Interfaces\MenuItem\MenuItemServiceInterface;
use App\Models\MenuItems;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class MenuItemService extends BaseService implements MenuItemServiceInterface
{
    public function __construct(
        private MenuItems $items,
    ){}

    public function store(array $data): void
    {
        try{
            $this->items->create($data);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao salvar item do menu');
        }
    }

    public function update(array $data): void
    {
        try{
            $item = $this->items->find($data['id']);

            if(!$item){
                throw new SistemException('Item não encontrado',404);
            }

            $item->update($data);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(),$e->getCode());
        }
    }

    public function get(int $id, int $restaurant_id): MenuItems
    {
        try{
            $user = auth()->user();

            $this->ensureAdminMasterOrRestaurantOwner($user, $restaurant_id);

            return $this->items
                ->with('menu','category')
                ->where('id', $id)->first();

        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(),$e->getCode());
        }
    }

    public function getAll(int $restaurant_id): Collection
    {
        try{
            $user = auth()->user();

            $this->ensureAdminMasterOrRestaurantOwner($user, $restaurant_id);

            return $this->items
                ->select(
                    'menu_items.id',
                    'menu_items.name',
                    'menu_items.description',
                    'menu_items.price',
                    'menu_items.menu_id',
                    'menu_items.active',
                    'menu.restaurant_id',
                )
                ->join(
                    'menu','menu_id','=','menu.id'
                )
                ->where('menu_items.active', true)
                ->where('restaurant_id', $restaurant_id)
                ->get();

        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(),$e->getCode());
        }
    }

    public function destroy(int $id, int $restaurant_id): void
    {
        try{
            $user = auth()->user();

            $this->ensureAdminMasterOrRestaurantOwner($user, $restaurant_id);
            
            $menuItem = $this->items->find($id);  

            if(!$menuItem){
                throw new SistemException('Item não encontrado',404);
            }

            $menuItem->update(['active'=> false]);

        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(),$e->getCode());
        }
    }

    public function delete(int $id, int $restaurant_id): void
    {
        try{
            $user = auth()->user();

            $this->ensureAdminMasterOrRestaurantOwner($user, $restaurant_id);
            
            $this->items->find($id)->delete();
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao deletar item do menu');
        }
    }


}