<?php

namespace App\Http\Controllers;

use App\Models\Mpesa;
use App\Models\Players;
use App\Models\User as Radio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RadioController extends Controller
{
    public function dashboard()
    {

        $radio = auth()->user();
        if ($radio->type == 'paybill') {
            $dailyTotals = Players::select(
                DB::raw("(sum(TransAmount)) as TransAmount"),
                DB::raw("(DATE_FORMAT(TransTime, '%d-%M-%Y')) as TransTime")
            )->groupBy(DB::raw("DATE_FORMAT(TransTime, '%d-%M-%Y')"))->where('BusinessShortCode', $radio->shortcode)->where('BillRefNumber', 'LIKE', '%' . $radio->account . '%')->get();
            $totalToday = Players::whereDate('TransTime', date('Y-m-d'))->where('BusinessShortCode', $radio->shortcode)->where('BillRefNumber', 'LIKE', '%' . $radio->account . '%')->sum('TransAmount');
        } else {
            $dailyTotals = Players::select(
                DB::raw("(sum(TransAmount)) as TransAmount"),
                DB::raw("(DATE_FORMAT(TransTime, '%d-%M-%Y')) as TransTime")
            )->groupBy(DB::raw("DATE_FORMAT(TransTime, '%d-%M-%Y')"))->where('BusinessShortCode', $radio->shortcode)->get();
            $totalToday = Players::whereDate('TransTime', date('Y-m-d'))->where('BusinessShortCode', $radio->shortcode)->sum('TransAmount');
        }


        return view('dashboard', ['dailyTotals' => $dailyTotals, 'totalToday' => $totalToday]);
    }
    public function players()
    {
        $radio = auth()->user();
        if ($radio->type == 'paybill') {
            $last_index = Players::where('BusinessShortCode', $radio->shortcode)->where('BillRefNumber', 'LIKE', '%' . $radio->account . '%')->latest()->first();
        } else {
            $last_index = Players::where('BusinessShortCode', $radio->shortcode)->latest()->first();
        }

        if ($last_index == null) {
            $last_index_id = 0;
        } else {
            $last_index_id = $last_index->id;
        }

        return view('players', ['last_index' => $last_index_id]);
    }
    public function online($index)
    {
        $radio = auth()->user();
        if ($radio->type == 'paybill') {
            $data = [
                'new_players' => Players::where('id', '>', $index)->where('BusinessShortCode', $radio->shortcode)->where('BillRefNumber', 'LIKE', '%' . $radio->account . '%')->get(),
                'totalAmount' => Players::whereDate('TransTime', date('Y-m-d'))->where('BusinessShortCode', $radio->shortcode)->where('BillRefNumber', 'LIKE', '%' . $radio->account . '%')->sum('TransAmount'),
            ];
        } else {
            $data = [
                'new_players' => Players::where('id', '>', $index)->where('BusinessShortCode', $radio->shortcode)->get(),
                'totalAmount' => Players::whereDate('TransTime', date('Y-m-d'))->where('BusinessShortCode', $radio->shortcode)->sum('TransAmount'),
            ];
        }


        return $data;
        // return view('session');
        // return view('players');
    }

    // Admin routes
    public function radios()
    {
        $radios = Radio::where('role', 'radio')->get();
        return view('radios', ['radios' => $radios, 'mpesas' => Mpesa::all()]);
    }

    public function radio_view(Radio $radio)
    {
        if ($radio->type == 'paybill') {
            $dailyTotals = Players::select(
                DB::raw("(sum(TransAmount)) as TransAmount"),
                DB::raw("(DATE_FORMAT(TransTime, '%d-%M-%Y')) as TransTime")
            )->groupBy(DB::raw("DATE_FORMAT(TransTime, '%d-%M-%Y')"))->where('BusinessShortCode', $radio->shortcode)->where('BillRefNumber', 'LIKE', '%' . $radio->account . '%')->get();
        } else {
            $dailyTotals = Players::select(
                DB::raw("(sum(TransAmount)) as TransAmount"),
                DB::raw("(DATE_FORMAT(TransTime, '%d-%M-%Y')) as TransTime")
            )->groupBy(DB::raw("DATE_FORMAT(TransTime, '%d-%M-%Y')"))->where('BusinessShortCode', $radio->shortcode)->get();
        }
        return view('view_radio', ['radio' => $radio, 'dailyTotals' => $dailyTotals]);
    }
    public function add_radio(Request $request)
    {
        Radio::create([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
            'type' => $request->type,
            'password' => Hash::make($request->password),
            'shortcode' => $request->shortcode,
            'account' => $request->account,
        ]);
        return redirect()->route('radios');
    }
    public function update_radio(Request $request, Radio $radio)
    {
        $radio->update($request->all());
        return redirect()->route('radios');
    }
    public function delete_radio(Radio $radio)
    {
        $radio->delete();
        return redirect()->route('radios');
    }
}
