<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Auth;
use App\Http\Requests;
use App\AuthenticateUser;

class AuthController extends Controller
{
    public function login(AuthenticateUser $authenticateUser, Request $request, $provider = null) {
        return $authenticateUser->execute($request->all(), $this, $provider);
    }

    public function userHasLoggedIn ($user) {
        return Redirect::route('landing');
    }
}
