<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FileOrganizer extends Model
{
    protected $fillable = [
        'user_id',
        'related_id',
        'related_model',
        'uuid',
        'title',
        'file_name',
    ];

    protected $casts = [
        'uuid' => 'string',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($file_organizer) {
            $file_organizer->uuid = Str::uuid();
        });
    }

    public function auction() {
        return $this->belongsTo(Auction::class, 'related_id', 'id');
    }

    public function scopeOfAuction($query, $auction_id) {
        return $query->whereRelatedId($auction_id);
    }
}
