<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItems extends Model
{
    use HasFactory;
    
    protected $table = "menu_items";

    protected $fillable = [
        'menu_id',
        'name',
        'description',
        'image',
        'price',
        'active',
        'image',
        'category_id'
    ];

    public function menu() :BelongsTo
    {
        return $this->belongsTo(Menu::class,'menu_id');
    }

    public function category() :BelongsTo
    {
        return $this->belongsTo(Categories::class,'category_id');
    }
}
