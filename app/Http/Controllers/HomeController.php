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

class HomeController extends Controller
{

    public function __construct(\Illuminate\Http\Request $request)
    {
//        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index(Guard $auth) {
        //goto welcome/ home page when logged in
        if ($auth->check()) {
            return View('home.welcome');
        }

        //Dont want to show navbar on landing page
        View::share('can_render_navbar', false);

        //if not logged goto landing page
        return View('home.landing');
    }

}
