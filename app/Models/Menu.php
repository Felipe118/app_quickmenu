<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $table = "menu";

    protected $fillable = [
        'name',
        'description',
        'image',
        'restaurant_id',
        'qrcode_path',
        'active',
        'slug',
    ];

    public function items() :HasMany
    {
        return $this->hasMany(MenuItems::class,'menu_id');
    }

    public function restaurant() :BelongsTo
    {
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }

    public function scopeVisibleTo($query,$user)
    {
        if ($user->hasRole('admin_master')) {
            return $query;
        }
      
        return $query->whereIn('restaurant_id', $user->restaurants()->pluck('restaurant_id'));
    }
}
