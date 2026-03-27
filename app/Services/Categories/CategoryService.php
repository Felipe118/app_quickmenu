<?php

namespace App\Services\Categories;

use App\Exceptions\SistemException;
use App\Interfaces\Categories\CategoryServiceInterface;
use App\Models\Categories;
use App\Models\User;
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

    public function getCategory(Categories $category, User $user): Categories
    {
        try{
            $category = Categories::visibleTo($user)
                ->where('id', $category->id)
                ->where('active', true)
                ->first();

            if($category === null){
                throw new SistemException('Categoria não encontrada',404);
            }
                
            return $category;

        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(), $e->getCode() ?? 500);
        }   
    }

    public function index(int $restaurant_id, User $user):Collection
    {
       try{
            return Categories::visibleTo($user)
                ->where('restaurant_id', $restaurant_id)
                ->where('active', true)
                ->get();

            if($category === null){
                throw new SistemException('Categorias não encontradas',404);
            }

            return $category;

       }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(), $e->getCode() ?? 500);
       }
    }

    public function update(Categories $categories, array $data):void
    {
        try{
            $categories->update($data);
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

    public function delete(int $id):void
    {
        try{
            Categories::find($id)->delete();
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao deletar categoria');
        }
    }


}