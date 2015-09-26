<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityAddress extends Model
{
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'entity_address';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('full_address_text','street_name','route','locality','neighborhood','administrative_area_level_2','administrative_area_level_1','country','postal_zip','geo_location');

    protected $guarded = array();

}
