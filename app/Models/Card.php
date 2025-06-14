<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';

    protected $primaryKey = 'number';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'brand',
        'bank',
        'number',
        'limit',
        'dni',
        'first_name',
        'last_name',
    ];

    public $timestamps = true;
}
