<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="MenuItem",
 *     title="MenuItem",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Item 1"),
 *     @OA\Property(property="description", type="string", example="Delicious item"),
 *     @OA\Property(property="price", type="number", format="float", example=10.99),
 *     @OA\Property(property="image", type="string", example="https://example.com/image.jpg"),
 *     @OA\Property(property="active", type="boolean", example=true),
 *     @OA\Property(property="menu_id", type="integer", example=1),
 *     @OA\Property(property="category_id", type="integer", example=2),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-09T03:58:10.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-09T03:58:10.000000Z")
 * )
 */
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

    public function scopeVisibleTo($query,$user)
    {
        if ($user->hasRole('admin_master')) {
            return $query;
        }
      
        return $query->whereIn('restaurant_id', $user->restaurants()->pluck('restaurant_id'));
    }
}
