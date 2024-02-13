<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:coupons");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('coupons');
    }
}
