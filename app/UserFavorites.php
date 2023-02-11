<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFavorites extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'related_id',
        'model',
        'price',
        'currency'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function auctions()
    {
        return $this->belongsTo(Auction::class, 'related_id', 'id');
    }
}
