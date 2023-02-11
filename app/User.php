<?php

namespace App;

use App\Gamify\Points\UserRegister;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Storage;
use QCod\Gamify\Gamify;
use QCod\Gamify\HasReputations;


class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes, HasApiTokens, Gamify;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active', 'activation_token', 'avatar', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'activation_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    protected $appends = ['avatar_url'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($user) {
            $user->givePoint(new UserRegister($user));
        });

        static::creating(function ($user){
            $user->username = Str::slug('misafir '.rand(1777,50000), '-');
        });
    }

    public function getAvatarUrlAttribute()
    {
        return Storage::url('avatars/' . $this->id . '/' . $this->avatar);
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function cart() {
        return $this->hasMany(Cart::class);
    }
}
