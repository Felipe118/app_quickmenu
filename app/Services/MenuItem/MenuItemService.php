<?php

namespace App\Services\MenuItem;

use App\Exceptions\SistemException;
use App\Interfaces\MenuItem\MenuItemServiceInterface;
use App\Models\MenuItems;
use App\Models\Restaurant;
use App\Models\User;
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

    public function index(Restaurant  $restaurant, User $user) :Collection
    {
        try{ 
            $this->ensureAdminMasterOrRestaurantOwner($user, $restaurant->id);

            return $this->items->with(['menu','category'])
                ->where('active', true)
                ->get();
        }catch(\Exception $e){
            dd($e);
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(),$e->getCode() ?? 500);
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