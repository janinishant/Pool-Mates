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

    public static function getDistanceAmongRequestsByTimeFilteredIds($time_filtered_ids, $lat, $lng, $request_column) {
        $time_filtered_requests_id = '(' . implode(',', $time_filtered_ids) . ')';

        return DB::select(DB::raw("SELECT entity_address.id,glength(LineStringFromWKB(LineString(GeomFromText(
                  astext(PointFromWKB(POINT(($lat),($lng))))),
                  GeomFromText(astext(PointFromWKB(POINT(X(geo_location),Y(geo_location))))))))*100
                  AS distance from entity_address, requests
                  where `requests`.`$request_column` = `entity_address`.`id`
                  AND requests.id IN ($time_filtered_requests_id) order by distance"));
    }

}
