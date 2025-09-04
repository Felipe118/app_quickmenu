<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QrCode extends Model
{
    protected $table = 'qrcode';

    protected $fillable = [
        'description',
        'payload',
        'menu_id',
    ];

    public function menu() :BelongsTo
    {
        return $this->belongsTo(Menu::class,'menu_id');
    }
}
