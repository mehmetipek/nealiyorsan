<?php

namespace App;

use App\Gamify\Points\ProfileUpdate;
use Illuminate\Database\Eloquent\Model;
use QCod\Gamify\Gamify;

class UserProfile extends Model
{
    use Gamify;
    protected $fillable = [
        'user_id',
        'city_id',
        'phone',
        'address_1',
        'address_2',
        'government_id',
        'confirmation_1',
        'confirmation_2',
    ];

    public static function boot()
    {
        parent::boot();
        static::created(function ($user_profile) {
            $user_profile->givePoint(new ProfileUpdate($user_profile));
        });
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function city() {
        return $this->hasOne(City::class);
    }

}
