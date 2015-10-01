<?php

namespace App\Http\Controllers;

use App\Models\EntityAddress;
use App\Models\RequestStatuses;
use Illuminate\Http\Request;
use Auth;
use App\Models\Requests;
use App\Models\RequestPickupTimes;
use App\Models\PickupTimes;
use DB;

class RequestController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {

        //id of the user who is making the request
        $requester_id = Auth::user()->id;

        //Validate the request.
        $this->validate($request, array(
            'pick-up-location' => 'required',
            'drop-off-location' => 'required',
            'pick-up-time' => 'required',
            'sourceAddressComponents.lat' => 'required|max:90|min:-90',
            'destinationAddressComponents.lat' => 'required|max:90|min:-90',
            'sourceAddressComponents.lng' => 'required|max:180|min:-180',
            'destinationAddressComponents.lng' => 'required|max:180|min:-180',
            'destinationAddressComponents.country' => 'required|max:180|min:-180',
        ));

        $source_lat = $request->input('sourceAddressComponents.lat', 0);
        $source_lng = $request->input('sourceAddressComponents.lng', 0);

        $destination_lat = $request->input('destinationAddressComponents.lat', 0);
        $destination_lng = $request->input('destinationAddressComponents.lng', 0);

        //Store mapping of address get the id
        $source_address = EntityAddress::firstOrCreate(array(
            'full_address_text' => $request->input('pick-up-location', ''),
            'street_name' => $request->input('sourceAddressComponents.street_number', ''),
            'route' => $request->input('sourceAddressComponents.route', ''),
            'locality' => $request->input('sourceAddressComponents.locality', ''),
            'neighborhood' => $request->input('sourceAddressComponents.neighborhood', ''),
            'administrative_area_level_2' => $request->input('sourceAddressComponents.administrative_area_level_2', ''),
            'administrative_area_level_1' => $request->input('sourceAddressComponents.administrative_area_level_1', ''),
            'country' => $request->input('sourceAddressComponents.country', ''),
            'postal_zip' => $request->input('sourceAddressComponents.postal_code', ''),
            'geo_location' => DB::raw("(GeomFromText('POINT($source_lat $source_lng)'))"),
        ));

        //Store mapping of destination address
        //if it already exists use that address id.
        $destination_address = EntityAddress::firstOrCreate(array(
            'full_address_text' => $request->input('drop-off-location', ''),
            'street_name' => $request->input('destinationAddressComponents.street_number', ''),
            'route' => $request->input('destinationAddressComponents.route', ''),
            'locality' => $request->input('destinationAddressComponents.locality', ''),
            'neighborhood' => $request->input('destinationAddressComponents.neighborhood', ''),
            'administrative_area_level_2' => $request->input('destinationAddressComponents.administrative_area_level_2', ''),
            'administrative_area_level_1' => $request->input('destinationAddressComponents.administrative_area_level_1', ''),
            'country' => $request->input('destinationAddressComponents.country', ''),
            'postal_zip' => $request->input('destinationAddressComponents.postal_code', ''),
            'geo_location' =>  DB::raw("(GeomFromText('POINT($destination_lat $destination_lng)'))"),
        ));

        //get default status when request is created.
        $request_status_id = RequestStatuses::getDefaultRequestStatus();

        //Store the request.
        $pool_request = Requests::create(array(
            'requester_id' => $requester_id,
            'source_address_id' => $source_address->id,
            'destination_address_id' => $destination_address->id,
            'request_status_id' => $request_status_id
        ));

        //get all values from pickup times table
        $pickup_times = PickupTimes::all()->toArray();
        $lookup_hash = array();
        foreach($pickup_times as $index => $arr) {
            $lookup_hash[$arr['id']] = $arr['time_value'];
        }

        //Store the mapping of times
        $pickup_times = $request->input('pick-up-time');
        $request_pickup_time_array = array();
        foreach($pickup_times as $index => $time) {
            $timestamp = time();
            if (isset($lookup_hash[$time+1])) {
                $today_date = date('Y-m-d');
                $timestamp = $today_date. ' '. $lookup_hash[$time+1];
            }
            $request_pickup_time_array[] = array(
                'request_id' => $pool_request->id,
                'pickup_timestamp' => $timestamp
            );
        }
        RequestPickupTimes::insert($request_pickup_time_array);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

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
