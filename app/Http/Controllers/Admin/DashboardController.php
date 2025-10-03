<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\LogAktivitas;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $data = [
            'today'            => Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->isoFormat('dddd, D MMMM Y'),
            'userCount'        => User::count(),
        ];

        return view('admin.dashboard.index', $data)->with('sb', 'Dashboard');
    }
}
