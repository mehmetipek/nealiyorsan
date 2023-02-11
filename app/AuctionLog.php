<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuctionLog extends Model
{
    protected $fillable = [
        'user_id',
        'auction_id',
        'status',
        'status_message',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
