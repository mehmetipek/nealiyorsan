<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['locale_code', 'continent_code', 'continent_name', 'country_iso_code', 'country_name', 'subdivision_1_iso_code', 'subdivision_1_name', 'subdivision_2_iso_code', 'subdivision_2_name', 'city_name', 'metro_code', 'time_zone', 'is_in_european_union'];

    //City::whereNull('city_name')->whereNotNull('subdivision_1_name')->where('country_iso_code', 'TR')->orderBy('subdivision_1_iso_code', 'ASC')->pluck('subdivision_1_name', 'id');

}
