<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QrCode extends Model
{
    protected $table = 'qrcode';

    protected $fillable = [
        'description',
        'payload',
    ];

    public function menu() :HasOne
    {
        return $this->hasOne(Menu::class,'qrcode_id');
    }
}
