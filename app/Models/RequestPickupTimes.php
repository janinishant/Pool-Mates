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

    /**
     * Filtering the requests to consider only requests
     * Not belonging to requested user
     * The requests only belong to today
     * @param $request_pickup_times_array
     * @param $request_id
     * @param $requester_id
     * @return mixed
     */
    public static function getRequestWithMatchingPickup($request_pickup_times_array, $request_id, $requester_id) {
        $rpt = new RequestPickupTimes();

        //filtering request for today only
        $today_beginning_timestamp = strtotime('today');
        $today_ending_timestamp = strtotime('tomorrow') -1;

        $range_start = date('Y-m-d H:i:s', $today_beginning_timestamp);
        $range_end = date('Y-m-d H:i:s', $today_ending_timestamp);


        return DB::table($rpt->table)
            ->join('requests', 'requests.id', '=', $rpt->table.'.request_id')
            ->whereIn('pickup_timestamp',  $request_pickup_times_array)
            ->where('request_id', '!=', $request_id)
            ->where('requests.requester_id', '!=', $requester_id)
            ->select('request_id','pickup_timestamp')
            ->whereBetween($rpt->table.'.pickup_timestamp', array($range_start, $range_end))
            ->get();
    }

    /**
     * Formats pickup times for api response
     * @param array $pickup_times
     * @return array
     */
    public static function formatPickUpTimesForAPI (array $pickup_times) {
        $response = array();
        foreach($pickup_times as $index => $pickup_time) {
            $response[$pickup_time['pickup_timestamp']] = true;
        }
        return $response;
    }

}
