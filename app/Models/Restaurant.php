<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Restaurant extends Model
{
    protected $table = 'restaurant';

    protected $fillable = [
        'name',
        'perfil_img',
        'capa_img',
        'email',
        'open_time',
        'close_time',
        'phone',
        'active',
        'address_id'
    ];

    public function users() :BelongsToMany
    {
        return $this->belongsToMany(User::class,
         'restaurant_users',
         'restaurant_id',
         'user_id'
        );
    }
}
