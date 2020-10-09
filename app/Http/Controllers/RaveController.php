<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Rave;

class RaveController extends Controller
{
    public function initialize()
    {
        Rave::initialize(route('callback'));
    }

    public function callback()
    {
        $data = Rave::verifyTransaction(request()->txref);

        dd($data);
    }
}
