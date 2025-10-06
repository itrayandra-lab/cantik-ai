<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GuestController extends Controller
{
    /**
     * Display the home page with a list of products.
     */
    public function home(Request $request)
    {
        return view('guest.home');
    }

    public function comingsoon()
    {
        return view('guest.coming-soon');
    }

    
}
