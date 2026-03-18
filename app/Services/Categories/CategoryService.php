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

    public function getCategoryAdmin(int $id_category): Categories
    {
          $category = Categories::find($id_category);

            if(!$category){
                throw new SistemException('Categoria não encontrada',404);
            }
                
            return $category;
    }

    public function getCategory(int $id, ?int $restaurant_id): Categories
    {
        try{  
            $category = Categories::where('restaurant_id', $restaurant_id)
            ->where('active', true)
                ->find($id);

            if(!$category){
                throw new SistemException('Categoria não encontrada',404);
            }
                
            return $category;

        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(), $e->getCode());
        }   
    }

    public function getAll(?int $restaurant_id = null):Collection
    {
       try{
            if(is_null($restaurant_id)){
                return Categories::all();
            }

            $category = Categories::where('restaurant_id', $restaurant_id)
                ->get();

            if($category->isEmpty()){
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

    public function destroy(int $id):void
    {
        try{
            Categories::find($id)->update(['active' => false]);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao desativar categoria');
        }
    }

    public function delete(int $id_category,int|null $id_restaurant = null):void
    {
        try{
            if(is_null($id_restaurant)){
                Categories::find($id_category)->delete();
            }

           $category = Categories::where('restaurant_id', $id_restaurant)
                ->where('id', $id_category)->first();
              

            if(!$category){
                throw new SistemException('Categoria não encontrada',404);
            }

            $category->delete();

        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao deletar categoria');
        }
    }
}