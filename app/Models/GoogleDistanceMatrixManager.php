<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GoogleDistanceMatrixManager
 * @package App\Models
 */
class GoogleDistanceMatrixManager extends Model
{
    /**
     * Language to expect the response of google api
     */
    const GDM_RESPONSE_LANGUAGE = 'en';

    /**
     * Imperial returns gdm response in miles and feet.
     * Can change to return meters and km.
     */
    const GDM_RESPONSE_UNITS = 'imperial';

    /**
     * @param $origins
     * @param $destinations
     * @param string $mode
     * @return mixed
     */
    public static function get_distance_matrix($origins, $destinations, $mode = 'walking')
    {
        $curl = curl_init();

        $gdm_url = env('GOOGLE_DISTANCE_MATRIX_URL');

        $gdm_options = array(
            'origins' => implode("|", $origins),
            'destinations' => implode("|", $destinations),
            'key' => env('GOOGLE_DISTANCE_MATRIX_KEY'),
            'mode' => $mode,
            'units' => self::GDM_RESPONSE_UNITS,
            'language' => self::GDM_RESPONSE_LANGUAGE
        );

        $gdm_options = http_build_query($gdm_options);
        $gdm_url .= "?" . $gdm_options;

        curl_setopt($curl, CURLOPT_URL, $gdm_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    //Sort the destinations by distance
    private function sort_destination_by_distance() {

    }
}