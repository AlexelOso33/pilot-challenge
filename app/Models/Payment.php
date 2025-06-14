<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'card_id',
        'amount',
        'installments',
        'surcharge',
        'total',
        'ticket_data',
    ];

    public $timestamps = true;
}
