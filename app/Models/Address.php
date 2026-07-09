<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
