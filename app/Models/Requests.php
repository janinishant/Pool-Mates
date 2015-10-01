<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Requests extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('requester_id', 'source_address_id', 'destination_address_id','request_status_id');

    /**
     * Get the source address for a request
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sourceAddress() {
        return $this->hasOne('App\Models\EntityAddress','id','source_address_id')
            ->select(array(DB::raw('X(geo_location) as `lat`'), DB::raw('Y(geo_location) as lng'), DB::raw('entity_address.*')));
    }

    /**
     * Get the destination address for a request
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function destinationAddress() {
        return $this->hasOne('App\Models\EntityAddress', 'id', 'destination_address_id')
            ->select(array(DB::raw('X(geo_location) as `lat`'), DB::raw('Y(geo_location) as lng'), DB::raw('entity_address.*')));
    }

    /**
     * Get the mapped request statuses
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function requestStatus() {
        return $this->hasOne('App\Models\RequestStatuses', 'id', 'request_status_id');
    }

    /**
     * Get the mapped request times
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requestPickupTimes() {
        return $this->hasMany('App\Models\RequestPickupTimes', 'request_id', 'id');
    }

}
