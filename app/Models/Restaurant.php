<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use HasFactory;
    
    protected $table = 'restaurant';

    protected $hidden = ['user'];

    protected $fillable = [
        'name',
        'perfil_img',
        'capa_img',
        'email',
        'open_time',
        'close_time',
        'phone',
        'active',
        'address_id',
        'slug',
    ];



    public function users() :BelongsToMany
    {
        return $this->belongsToMany(User::class,
         'restaurant_users',
         'restaurant_id',
         'user_id'
        );
    }

    public function address():HasOne
    {
        return $this->hasOne(Address::class,'id','address_id');
    }

    public function menus() :HasMany
    {
        return $this->hasMany(Menu::class,'restaurant_id');
    }
}
