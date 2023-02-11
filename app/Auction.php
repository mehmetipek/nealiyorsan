<?php

namespace App;

use App\Gamify\Points\PublishAuction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use QCod\Gamify\Gamify;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Auction extends Model
{
    use SoftDeletes, HasSlug, Gamify;

    protected $fillable = [
        'id',
        'user_id',
        'admin_id',
        'category_id',
        'title',
        'direction',## 0 => Satış, 1 => Alış
        'description',
        'price',
        'min_price',
        'max_price',
        'currency',
        'status', // 0 bekliyor 1 Onaylı 2 İptal 3 yeniden yayına alınmayı bekliyor
        'is_draft',
        'is_trade',
        'uuid',
        'category_properties',
        'profile_picture'
    ];

    protected $hidden = ['deleted_at'];

    protected $casts = [
        'category_properties' => 'array'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($auction) {
            $auction->uuid = Str::uuid();
        });

        static::updating(function ($auction) {
            if ($auction->status == 1 && $auction->is_draft == 0) {
                $auction->givePoint(new PublishAuction($auction));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(FileOrganizer::class, 'related_id', 'id')->orderBy('id', 'desc');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function scopeWaitPublished($query, $user_id)
    {
        return $query->whereUserId($user_id)->whereIsDraft(0)->whereStatus(0)->with(['images']);
    }

    public function scopePublished($query, $user_id)
    {
        return $query->whereUserId($user_id)->whereIsDraft(0)->whereStatus(1)->with(['images']);
    }

    public function scopeUnpublished($query, $user_id)
    {
        return $query->whereUserId($user_id)->whereIsDraft(0)->whereStatus(2)->with(['images']);
    }

    public function scopeWaitRepublished($query, $user_id)
    {
        return $query->whereUserId($user_id)->whereIsDraft(0)->whereStatus(3)->with(['images']);
    }


}
