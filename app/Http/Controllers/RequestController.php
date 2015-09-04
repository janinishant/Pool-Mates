<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
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

        //Store mapping of address get the id


        //Store the mapping of times




        //Store the request.
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
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
