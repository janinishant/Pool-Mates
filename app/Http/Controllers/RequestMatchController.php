<?php

namespace App\Http\Controllers;

use App\Models\EntityAddress;
use App\Models\GoogleDistanceMatrixManager;
use App\Models\RequestPickupTimes;
use App\Models\RequestStatuses;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Requests as PMRequest;
use DB;

class RequestMatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

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

        $request_pickup_times = $request->requestPickupTimes->toArray();

        $request_pickup_times_array = array();
        foreach($request_pickup_times as $index => $vArray) {
            $request_pickup_times_array[] = $vArray['pickup_timestamp'];
        }

        $request_pickup_times_hash = array_flip($request_pickup_times_array);

        $time_filtered_requests = RequestPickupTimes::getRequestWithMatchingPickup($request_pickup_times_array, $id);

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
        $requests_by_source_distance = EntityAddress::getDistanceAmongRequestsByTimeFilteredIds($time_filtered_requests_ids, $source_address->lat, $source_address->lng, "source_address_id");
        $requests_by_source_distance = EntityAddress::formatSpatialQueryResponse($requests_by_source_distance, $request_pickup_times_hash);
        $requests_by_destination_distance = EntityAddress::getDistanceAmongRequestsByTimeFilteredIds($time_filtered_requests_ids, $destination_address->lat, $destination_address->lng, "destination_address_id");
        $requests_by_destination_distance = EntityAddress::formatSpatialQueryResponse($requests_by_destination_distance, $request_pickup_times_hash);

        $gdm_request_source = $source_address->lat.','.$source_address->lng;
        $gdm_request_destination = $destination_address->lat.','.$destination_address->lng;

        $gdm_request_potential_source_matches = array();
        $gdm_request_potential_destination_matches = array();


        foreach($requests_by_source_distance as $distance) {
            $gdm_request_potential_source_matches[] = $distance['latitude'].','.$distance['longitude'];
        }

        foreach($requests_by_destination_distance as $distance) {
            $gdm_request_potential_destination_matches[] = $distance['latitude'].','.$distance['longitude'];
        }

        $gdm_request_potential_source_matches = GoogleDistanceMatrixManager::get_distance_matrix($gdm_request_source, $gdm_request_potential_source_matches);
        $gdm_request_potential_source_matches = json_decode($gdm_request_potential_source_matches, true);
        $gdm_request_potential_destination_matches = GoogleDistanceMatrixManager::get_distance_matrix($gdm_request_destination, $gdm_request_potential_destination_matches);
        $gdm_request_potential_destination_matches = json_decode($gdm_request_potential_destination_matches, true);


        $api_response = PMRequest::formatAPIResponse($request, $source_address, $destination_address, $requests_by_source_distance, $requests_by_destination_distance, $gdm_request_potential_source_matches, $gdm_request_potential_destination_matches);
        
        return $api_response;
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
