<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'auction_id',
        'price', // @info: float
        'currency',
        'attribute',
        'conditions', // @info: string -2%+-20TL şeklinde gelecektir.
        'quantity',
        'total'
    ];

    protected $casts = [
        'attribute' => 'array'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($cart) {
            $cart->total = $cart->quantity * $cart->price;
        });

        static::updating(function ($cart) {
            $cart->total = $cart->quantity * $cart->price;
        });
    }

    public function auction() {
        return $this->belongsTo(Auction::class);
    }


}
