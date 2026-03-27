<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categories extends Model
{
    use HasFactory;

    protected $table = "categories";

    protected $fillable = [
        'name',
        'description',
        'restaurant_id',
        'active'
    ];

    public function items() :HasMany
    {
        return $this->hasMany(MenuItems::class,'category_id');
    }

    public function scopeVisibleTo($query,$user)
    {
        if ($user->hasRole('admin_master')) {
            return $query;
        }
      
        return $query->whereIn('restaurant_id', $user->restaurants()->pluck('restaurant_id'));
    }
}
