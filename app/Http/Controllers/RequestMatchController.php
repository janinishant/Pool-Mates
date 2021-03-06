<?php

namespace App\Http\Controllers;

use App\Models\EntityAddress;
use App\Models\GoogleDistanceMatrixManager;
use App\Models\RequestPickupTimes;
use App\Models\RequestStatuses;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Requests as PMRequest;
use DB;
use Illuminate\Support\Facades\Config;

class RequestMatchController extends PMBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        User::getUserForRequest(1);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Get the matching request for the given request id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //Unique namespace for request PMRequest.
        $request = PMRequest::find($id);

        //Not a valid request
        if (empty($request)) {
            return parent::InvalidRequestResponseHandler();
            exit;
        }

        $request_pickup_times = $request->requestPickupTimes->toArray();

        $request_pickup_times_array = array();
        foreach($request_pickup_times as $index => $vArray) {
            $request_pickup_times_array[] = $vArray['pickup_timestamp'];
        }

        $request_pickup_times_hash = array_flip($request_pickup_times_array);

        $time_filtered_requests = RequestPickupTimes::getRequestWithMatchingPickup($request_pickup_times_array, $id, $request->requester_id);

        //No requests matched, you want to suggest somthing to the user here
        if (empty($time_filtered_requests)) {
            return parent::NoRequestMatchResponseHandler();
            exit;
        }


        $result = array();
        foreach($time_filtered_requests as $index => $request_info) {
            if (!isset($result[$request_info->request_id])) {
                $result[$request_info->request_id] = array();
            }
            $result[$request_info->request_id]['pickup_time'][] = $request_info->pickup_timestamp;
        }

        $time_filtered_requests_ids = array_keys($result);
        //get source address for my request
        $source_address = $request->sourceAddress;
        //get destination address for my request.
        $destination_address = $request->destinationAddress;

        //Get spatial distance from MySQL for source address
        $requests_by_source_distance = EntityAddress::getDistanceAmongRequestsByTimeFilteredIds($time_filtered_requests_ids, $source_address->lat, $source_address->lng, "source_address_id", $request_pickup_times_hash);
        $requests_by_destination_distance = EntityAddress::getDistanceAmongRequestsByTimeFilteredIds($time_filtered_requests_ids, $destination_address->lat, $destination_address->lng, "destination_address_id", $request_pickup_times_hash);

        $gdm_request_source = EntityAddress::getCSVForLatLong($source_address);
        $gdm_request_destination = EntityAddress::getCSVForLatLong($destination_address);

        $gdm_request_potential_source_matches = EntityAddress::getCSVForLatLong($requests_by_source_distance);
        $gdm_request_potential_destination_matches = EntityAddress::getCSVForLatLong($requests_by_destination_distance);


        $gdm_request_potential_source_matches = GoogleDistanceMatrixManager::get_distance_matrix($gdm_request_source, $gdm_request_potential_source_matches, Config::get('pm_constants.formats.array'));
        $gdm_request_potential_destination_matches = GoogleDistanceMatrixManager::get_distance_matrix($gdm_request_destination, $gdm_request_potential_destination_matches, Config::get('pm_constants.formats.array'));

        $api_response = PMRequest::formatAPIResponse($request, $source_address, $destination_address, $requests_by_source_distance, $requests_by_destination_distance, $gdm_request_potential_source_matches, $gdm_request_potential_destination_matches);

        return parent::ValidResponseHandler($api_response);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
