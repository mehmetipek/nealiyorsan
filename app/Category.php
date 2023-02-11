<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait, HasSlug, SoftDeletes;
    protected $fillable = ['name', 'slug', 'fields', 'status'];

    protected $hidden = ['deleted_at'];

    protected $casts = [
        'fields' => 'array'
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function field_types() {
        return $this->hasMany(FieldType::class);
    }
}
