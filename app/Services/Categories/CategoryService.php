<?php

namespace App\Services\Categories;

use App\Exceptions\SistemException;
use App\Interfaces\Categories\CategoryServiceInterface;
use App\Models\Categories;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class CategoryService extends BaseService implements CategoryServiceInterface
{
    public function store(array $data):void
    {
        try{
            Categories::create($data);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao salvar categoria');
        }
       
    }

    public function getCategory(int $id, int $restaurant_id): Categories
    {
        try{
            $user = auth()->user();

            $this->ensureAdminMasterOrRestaurantOwner($user, $restaurant_id);

            $category = Categories::where('restaurant_id', $restaurant_id)
                ->find($id);

            if($category == null){
                throw new SistemException('Categoria não encontrada',404);
            }
                
            return $category;

        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(), $e->getCode());
        }   
    }

    public function getAll(int $restaurant_id):Collection
    {
       try{
            $user = auth()->user();

            $this->ensureAdminMasterOrRestaurantOwner($user, $restaurant_id);

            $category = Categories::where('restaurant_id', $restaurant_id)
                ->get()
                ->toArray();
            
            dd($category);

            if($category == null){
                throw new SistemException('Categorias não encontradas',404);
            }

            return $category;

       }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(), $e->getCode());
       }
    }

    public function update(array $data):void
    {
        try{
            Categories::find($data['id'])->update($data);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao atualizar categoria');
        }
    }


}