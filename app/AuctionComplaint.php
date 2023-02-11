<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuctionComplaint extends Model
{
    protected $fillable = [
        'id',
        'auction_id',
        'user_id',
        'complaint',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }

}
