<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{

    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index() {
        if (Auth::check()) {
            return View('home.welcome');
        }
        return View('home.landing');
    }
}
