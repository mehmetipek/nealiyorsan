<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class FieldTypeProperties extends Model
{
    use HasSlug, SoftDeletes;
    protected $fillable = ['field_type_id','value', 'slug', 'status'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('value')
            ->saveSlugsTo('slug');
    }

    public function field() {
        return $this->belongsTo(FieldType::class);
    }
}
