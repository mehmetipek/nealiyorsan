<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'offer_type_id',
        'auction_id',
        'offer_auction_id',
        'notes',
        'status'
    ];
    protected $casts = [
        'notes' => 'array'
    ];
}
