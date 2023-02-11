<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class FieldType extends Model
{
    use HasSlug, SoftDeletes;
    protected $fillable = ['name', 'category_id', 'slug', 'status', 'type', 'static_values', 'related', 'related_pluck'];

    protected $casts = [
        'static_values' => 'array',
        'related_pluck' => 'array',
    ];

    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];
    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function properties() {
        return $this->belongsTo(FieldTypeProperties::class);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
