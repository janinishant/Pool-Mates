<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestPickupTimes extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'request_pickup_times';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('request_id', 'time_id');

}
