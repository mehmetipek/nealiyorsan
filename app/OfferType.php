<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferType extends Model
{
    protected $fillable = [
        'name',
        'code',
        'auction_type',
        'status'
    ];
}
