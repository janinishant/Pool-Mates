<?php

namespace App\Http\Controllers;

use App\Models\GoogleDistanceMatrixManager;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class ProfileController extends Controller
{
    /**
     * Constructor for user controller
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(\Illuminate\Http\Request $request)
    {
//        parent::__construct($request);
//        $this->middleware('auth');
//        $this->middleware('isMindingOwnBusiness:id', ['except' => ['show']]);
    }


    public function userinfo(Guard $auth)
    {
        //goto profile page when logged in
        if ($auth->check()) {
            return View('profile');
        }

        //Dont want to show navbar on landing page
        View::share('can_render_navbar', false);

        //if not logged goto landing page
        return View('home.landing');
    }

    public function edituserinfo(Guard $auth)
    {
        //goto profile page when logged in
        if ($auth->check()) {
            return View('profile_edit');
        }

        //Dont want to show navbar on landing page
        View::share('can_render_navbar', false);

        //if not logged goto landing page
        return View('home.landing');
    }
}