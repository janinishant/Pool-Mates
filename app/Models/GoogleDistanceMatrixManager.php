<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

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
     * @param string $output_format
     * @return mixed
     */
    public static function get_distance_matrix($origins, $destinations, $output_format, $mode = 'walking')
    {
        $curl = curl_init();

        $gdm_url = env('GOOGLE_DISTANCE_MATRIX_URL');

        $gdm_options = array(
            'origins' => is_array($origins) ? implode("|", $origins) : $origins,
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

        if (Config::get('pm_constants.format.json') == $output_format) {
            return $result;
        }

        return json_decode($result, true);
    }
}
