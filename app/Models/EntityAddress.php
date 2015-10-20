<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
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

    /**
     * TODO: Add filter for open requests
     * @param $time_filtered_ids Requests that are valid in the time
     * @param Double $lat Request latitude
     * @param Double $lng Request longitude
     * @param String $request_column Match it to either source or destination
     * @return mixed
     */
    public static function getDistanceAmongRequestsByTimeFilteredIds($time_filtered_ids, $lat, $lng, $request_column) {
        $time_filtered_requests_id =  implode(',', $time_filtered_ids);

        return DB::select(DB::raw("SELECT requests.id as request_id, entity_address.id as address_id,
                  `request_pickup_times`.pickup_timestamp as `request_pickup_time`,
                  `entity_address`.`full_address_text` as `full_address_text`,
                  X(entity_address.geo_location) as latitude,
                  Y(entity_address.geo_location) as longitude,
                  glength(LineStringFromWKB(LineString(
                  GeomFromText(astext(PointFromWKB(POINT(($lat),($lng))))),
                  GeomFromText(astext(PointFromWKB(POINT(X(geo_location),Y(geo_location))))))))*100
                  AS distance from entity_address, requests, request_pickup_times
                  where `requests`.`$request_column` = `entity_address`.`id`
                  AND requests.id IN ($time_filtered_requests_id)
                  AND `requests`.`id` = `request_pickup_times`.`request_id`
                  having distance < 1
                  order by distance LIMIT 20"));
    }

    public static function formatSpatialQueryResponse($spatialQueryResponse, $requestPickupTimeHash) {
        $response = array();

        foreach($spatialQueryResponse as $row) {
            if (!isset($response[$row->request_id])) {
                $response[$row->request_id] = array();
            }
            if (!isset($response[$row->request_id]['request_pickup_times'])) {
                $response[$row->request_id]['request_pickup_times'] = array();
            }
            $response[$row->request_id]['address_id'] = $row->address_id;
            $response[$row->request_id]['full_address_text'] = $row->full_address_text;
            $response[$row->request_id]['latitude'] = $row->latitude;
            $response[$row->request_id]['longitude'] = $row->longitude;
            $response[$row->request_id]['spatial_estimate'] = $row->distance;

            if (isset($requestPickupTimeHash[$row->request_pickup_time])) {
                $response[$row->request_id]['request_pickup_times'][$row->request_pickup_time] = true;
            } else {
                $response[$row->request_id]['request_pickup_times'][$row->request_pickup_time] = false;
            }
        }
        return $response;
    }

}
