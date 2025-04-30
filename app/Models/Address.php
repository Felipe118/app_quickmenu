<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';

    protected $fillable = [
        'address_name',
        'quatrain',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'cep',
    ];
}
