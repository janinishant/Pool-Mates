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

    /**
     *
     * @param Request $request User Request
     * @param $source_address User Request source address
     * @param $destination_address User Request destination address
     * @param array $source_spatial_data Estimates returned by MySQL spatial query for source matches
     * @param array $destination_spatial_data Estimates returned by MySQL spatial query for destination matches
     * @param $gdm_request_potential_source_matches array Estimates returned by Google Distance Matrix API Request for source matches
     * @param $gdm_request_potential_destination_matches array Estimates returned by Google Distance Matrix API Request for destination matches
     * @return array
     */
    public static function formatAPIResponse($request, $source_address, $destination_address, array $source_spatial_data, array $destination_spatial_data, $gdm_request_potential_source_matches, $gdm_request_potential_destination_matches) {
        $api_response = array();
        $source_address_matched_request_ids_map = array_flip(array_keys($source_spatial_data));
        $destination_address_matched_request_ids_map = array_flip(array_keys($destination_spatial_data));
        $ideal_matches = array();
        $api_response['request_id'] = $request->id;
        $api_response['pickup_time'] = RequestPickupTimes::formatPickUpTimesForAPI($request->requestPickupTimes->toArray());
        $api_response['request_source_address'] = $source_address->full_address_text;
        $api_response['request_destination_address'] = $destination_address->full_address_text;
        $source_matches = self::formatAddressForAPIResponse($source_spatial_data, $gdm_request_potential_source_matches, $ideal_matches);
        $destination_matches = self::formatAddressForAPIResponse($destination_spatial_data, $gdm_request_potential_destination_matches, $ideal_matches, $source_address_matched_request_ids_map);


        foreach ($ideal_matches as $index => $match_request_id) {
            $api_response['best_matches'][$index]['request_id'] = $match_request_id;
            $api_response['best_matches'][$index]['pickup_times'] = $source_spatial_data[$match_request_id]['request_pickup_times'];
            //This is really bad, need to change this
            $api_response['best_matches'][$index]['matched_source'] = $source_matches[$source_address_matched_request_ids_map[$match_request_id]];
            $api_response['best_matches'][$index]['matched_destination'] = $destination_matches[$destination_address_matched_request_ids_map[$match_request_id]];
        }
        
        return $api_response;
    }

    /**
     * A common method that formats API data for source and destination matches.
     * @param $spatialData
     * @param $gdm_request_potential_source_matches array Assumes single source & multiple destinations
     * @param array $match_source_destination_pairs
     * @param $ideal_matches
     * @return array
     */
    public static function formatAddressForAPIResponse($spatialData, $gdm_request_potential_source_matches, &$ideal_matches, $match_source_destination_pairs = array()) {
        $api_response = array();
        $index = 0;
        foreach ($spatialData as $source_match_request_id => $row) {
            $api_response[$index]['full_address'] = $row['full_address_text'];
            $api_response[$index]['spatial_estimate'] = $row['spatial_estimate'];
            $api_response[$index]['gdm_full_address'] = $gdm_request_potential_source_matches['destination_addresses'][$index];
            //Zero is hard-coded in rows because we are assuming we send 1 source and multiple destinations
            $api_response[$index]['gdm_walk_distance_estimate'] = $gdm_request_potential_source_matches['rows'][0]['elements'][$index]['distance']['text'];
            $api_response[$index]['gdm_walk_duration_estimate'] = $gdm_request_potential_source_matches['rows'][0]['elements'][$index]['duration']['text'];

            if (!empty($match_source_destination_pairs) && isset($match_source_destination_pairs[$source_match_request_id])) {
                $ideal_matches[] = $source_match_request_id;
            }
            $index++;
        }
        return $api_response;
    }

}
