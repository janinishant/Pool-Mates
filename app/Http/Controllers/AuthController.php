<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Redirect;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AuthenticateUser;

class AuthController extends Controller
{
    public function login(AuthenticateUser $authenticateUser, Request $request, $provider = null) {
        return $authenticateUser->execute($request->all(), $this, $provider);
    }

    public function userHasLoggedIn ($user) {
        echo "<pre>";
        print_r($user);
        echo "</pre>";
        exit;

    }
}
