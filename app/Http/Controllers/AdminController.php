<?php

namespace App\Http\Controllers;

use App\Models\Players;
use App\Models\Presenter_Sessions;
use App\Models\Radio;
use App\Models\Radio_Mpesa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $dailyTotals =  $dailyTotals = Players::select(
            DB::raw("(sum(TransAmount)) as TransAmount"),
            DB::raw("(DATE_FORMAT(TransTime, '%d-%M-%Y')) as TransTime")
        )->groupBy(DB::raw("DATE_FORMAT(TransTime, '%d-%M-%Y')"))->get();
        $totalToday = Players::whereDate('TransTime', date('Y-m-d'))->sum('TransAmount');
        return view('dashboard', ['dailyTotals' => $dailyTotals, 'totalToday' => $totalToday]);
    }

    public function players()
    {
        return view('dashboard');
    }
}
