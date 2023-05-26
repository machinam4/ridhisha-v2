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
        $dailyTotals = Players::select(
            DB::raw("(sum(TransAmount)) as TransAmount"),
            DB::raw("(DATE_FORMAT(TransTime, '%d-%M-%Y')) as TransTime")
        )->groupBy(DB::raw("DATE_FORMAT(TransTime, '%d-%M-%Y')"))->where('BusinessShortCode', $radio->shortcode)->where('BillRefNumber', 'LIKE', '%' . $radio->account . '%')->get();
        $totalToday = Players::whereDate('TransTime', date('Y-m-d'))->where('BusinessShortCode', $radio->shortcode)->where('BillRefNumber', 'LIKE', '%' . $radio->account . '%')->sum('TransAmount');
        // $totalAmount = Players::where('user_id', $radio)->sum('TransAmount');

        return view('dashboard', ['dailyTotals' => $dailyTotals, 'totalToday' => $totalToday]);
    }
    public function players()
    {
        $radio = auth()->user();
        $last_index = Players::where('BusinessShortCode', $radio->shortcode)->where('BillRefNumber', 'LIKE', '%' . $radio->account . '%')->latest()->first();
        return view('players', ['last_index' => $last_index->id]);
    }
    public function online($index)
    {

        $data = [
            'new_players' => Players::where('id', '>', $index)->where('BusinessShortCode', auth()->user()->shortcode)->where('BillRefNumber', 'LIKE', '%' . auth()->user()->account . '%')->get(),
            'totalAmount' => Players::whereDate('TransTime', date('Y-m-d'))->where('BusinessShortCode', auth()->user()->shortcode)->where('BillRefNumber', 'LIKE', '%' . auth()->user()->account . '%')->sum('TransAmount'),
            // 'totalAmount' => Players::where('TransTime', '>', auth()->user()->sessions->last()->created_at)->where('user_id', auth()->user()->id)->sum('TransAmount'),
        ];
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

        $dailyTotals = Players::select(
            DB::raw("(sum(TransAmount)) as TransAmount"),
            DB::raw("(DATE_FORMAT(TransTime, '%d-%M-%Y')) as TransTime")
        )->groupBy(DB::raw("DATE_FORMAT(TransTime, '%d-%M-%Y')"))->where('BusinessShortCode', $radio->shortcode)->where('BillRefNumber', 'LIKE', '%' . $radio->account . '%')->get();

        // $totalToday = Players::whereDate('TransTime', date('Y-m-d'))->where('user_id', $radio)->sum('TransAmount');
        // dd($dailyTotals);
        return view('view_radio', ['radio' => $radio, 'dailyTotals' => $dailyTotals]);
    }
    public function add_radio(Request $request)
    {
        Radio::create([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
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
