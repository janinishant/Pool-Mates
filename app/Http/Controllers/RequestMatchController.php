<?php

namespace App\Http\Controllers;

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
        $request = PMRequest::find($id);

        $request_pickup_times = $request->requestPickupTimes->toArray();

        $request_pickup_times_array = array();
        foreach($request_pickup_times as $index => $vArray) {
            $request_pickup_times_array[] = $vArray['pickup_timestamp'];
        }

        $time_filtered_requests = DB::table('request_pickup_times')
            ->whereIn('pickup_timestamp',  $request_pickup_times_array)
            ->where('request_id', '!=', $id)
            ->select('request_id','pickup_timestamp')
            ->get();

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
