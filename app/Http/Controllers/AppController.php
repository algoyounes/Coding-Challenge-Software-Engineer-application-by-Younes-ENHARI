<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    //
    /**
     * Show Index page.
     *
     */
    public function index()
    {
        return view('app');
    }
}
