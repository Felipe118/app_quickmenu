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

    public function update(MenuItems $menuItem, array $data): void
    {
        try{
            $menuItem->update($data);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(),$e->getCode() ?: 500);
        }
    }

    public function get(MenuItems $menuItem): MenuItems
    {
        try{
            return $menuItem->load('menu','category');
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(),$e->getCode() ?: 500);
        }
    }

    public function getAll(int $restaurant_id): Collection
    {
        try{
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
            throw new SistemException($e->getMessage(),$e->getCode() ?: 500);
        }
    }

    public function destroy(MenuItems $menuItem): void
    {
        try{
            $menuItem->update(['active'=> false]);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(),$e->getCode() ?: 500);
        }
    }

    public function delete(MenuItems $menuItem): void
    {
        try{
            $menuItem->delete();
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao deletar item do menu');
        }
    }


}