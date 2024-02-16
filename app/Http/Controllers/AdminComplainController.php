<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminComplainController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:complains");
    }

    public function index()
    {
        return view("complains");
    }
}
