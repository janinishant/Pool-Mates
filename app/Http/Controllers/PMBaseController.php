<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;

abstract class PMBaseController extends Controller
{
    /**
     * Response handler for invalid bad requests
     * @return array
     */
    public static function InvalidRequestResponseHandler()
    {
        return array(
            'status' => Config::get('pm_constants.http_status_code.not_found'),
            'message' => 'Invalid Request, please check your input and try again'
        );
    }

    /**
     * Response handler for no requests matched
     * @return array
     */
    public static function NoRequestMatchResponseHandler()
    {
        return array(
            'status' => Config::get('pm_constants.http_status_code.ok'),
            'message' => 'Sorry, we currently have no request for the same locality. Please try again after some time'
        );
    }

    /**
     * Handler for valid responses
     * @param $data
     * @param array $meta
     * @return array
     */
    public static function ValidResponseHandler($data, $meta = array())
    {
        return array(
            'status' => Config::get('pm_constants.http_status_code.ok'),
            'data' => $data,
            'meta' => $meta
        );
    }

}
