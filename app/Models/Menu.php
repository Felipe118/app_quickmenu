<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Menu extends Model
{
    use HasFactory;

    protected $table = "menu";

    protected $fillable = [
        'name',
        'description',
        'image',
        'restaurant_id',
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

    public function qrcode() :HasOne
    {
        return $this->hasOne(QrCode::class,'menu_id');
    }
}
