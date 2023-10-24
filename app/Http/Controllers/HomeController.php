<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //$userId = Auth::id();
        //$user = Auth::getUser();
        //return view('home', compact('user'));
        return view('home');
    }
}
