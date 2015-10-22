<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Auth;
use App\Http\Requests;
use App\AuthenticateUser;
use Session;

class AuthController extends Controller
{
    public function login(AuthenticateUser $authenticateUser, Request $request, $provider = null) {
        return $authenticateUser->execute($request->all(), $this, $provider);
    }

    public function userHasLoggedIn ($user) {
        return Redirect::route('landing');
    }

    /**
     * Handle user logout and redirect to landing page
     *
     * Flush all user session data. Logout. Redirect.
     * @return mixed
     */
    public function logout()
    {
        //remove all session data, ironically not saving any session as of now! what a futuristic code, Ratta boy
        Session::flush();
        //logout the user
        Auth::logout();
        //Take to landing page
        return Redirect::route('landing');
    }
}
