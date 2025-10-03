<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Category;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Log;

class GuestController extends Controller
{
    /**
     * Display the home page with a list of products.
     */
    public function home(Request $request)
    {
        $categories = Category::select(['id', 'name', 'slug', 'description'])->get();

        return view('guest.home', compact('categories'));
    }

    public function comingsoon()
    {
        return view('guest.coming-soon');
    }

    
}
