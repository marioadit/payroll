<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function pa()
    {
        return view('paymentaccount');
    }

    public function worker()
    {
        return view('workerdata');
    }

    public function transaction()
    {
        return view('transaction');
    }

    public function logbook()
    {
        return view('logbook');
    }

    public function admin()
    {
        return view('admin');
    }
}