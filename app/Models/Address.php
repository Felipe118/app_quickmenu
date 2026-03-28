<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Address",
 *     title="Address",
 *     required={"address_name", "quatrain", "number", "city", "state", "cep"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="address_name", type="string", description="Nome do endereço"),
 *     @OA\Property(property="quatrain", type="string", description="Quadra"),
 *     @OA\Property(property="number", type="string"),
 *     @OA\Property(property="complement", type="string", nullable=true),
 *     @OA\Property(property="district", type="string", nullable=true),
 *     @OA\Property(property="city", type="string"),
 *     @OA\Property(property="state", type="string"),
 *     @OA\Property(property="neighborhood", type="string", nullable=true),
 *     @OA\Property(property="cep", type="string"),
 *     @OA\Property(property="created_at", type="string", format="date-time", readOnly=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true)
 * )
 */
class Address extends Model
{
    use HasFactory;
    
    protected $table = 'address';

    protected $fillable = [
        'address_name',
        'quatrain',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'neighborhood',
        'cep',
    ];
}
