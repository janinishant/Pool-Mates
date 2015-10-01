<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

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

    public static function getRequestWithMatchingPickup($request_pickup_times_array, $request_id) {
        $rpt = new RequestPickupTimes();
        return DB::table($rpt->table)
            ->whereIn('pickup_timestamp',  $request_pickup_times_array)
            ->where('request_id', '!=', $request_id)
            ->select('request_id','pickup_timestamp')
            ->get();
    }

}
