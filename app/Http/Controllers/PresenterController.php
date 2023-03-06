<?php

namespace App\Http\Controllers;

use App\Models\Players;
use App\Models\Presenter_Sessions;
use App\Models\Radio;
use App\Models\User as Presenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PresenterController extends Controller
{
    public function dashboard()
    {
        $presenter = auth()->user()->id;
        $dailyTotals = Players::select(
            DB::raw("(sum(TransAmount)) as TransAmount"),
            DB::raw("(DATE_FORMAT(TransTime, '%d-%M-%Y')) as TransTime")
        )->groupBy(DB::raw("DATE_FORMAT(TransTime, '%d-%M-%Y')"))->where('user_id', $presenter)->get();
        $totalToday = Players::whereDate('TransTime', date('Y-m-d'))->where('user_id', $presenter)->sum('TransAmount');
        // $totalAmount = Players::where('user_id', $presenter)->sum('TransAmount');
        return view('dashboard', ['dailyTotals' => $dailyTotals, 'totalToday' => $totalToday]);
    }
    public function players()
    {
        // return view('session');
        $ongoing = Presenter_Sessions::where('radio_id', auth()->user()->radio->id)->where('status', 1)->get();
        $last_index = Players::where('BusinessShortCode', auth()->user()->sessions->last()->shortcode)->latest()->first();
        return view('players', ['sessions' => $ongoing, 'last_index' => $last_index->id]);
    }

    public function start_session(Request $request)
    {
        $ongoing = Presenter_Sessions::where('radio_id', auth()->user()->radio->id)->where('status', 1)->get();
        if ($ongoing->count() >= 1) {
            // return $ongoing;
            return redirect()->route('presenter_players');
        } else {
            Presenter_Sessions::create([
                'user_id' => auth()->user()->id,
                'radio_id' => auth()->user()->radio->id,
                'shortcode' => $request->shortcode,
                'status' => 1,
            ]);
            return redirect()->route('presenter_players')->with(['message' => 'session started']);
        }
    }

    public function stop_session()
    {
        Presenter_Sessions::where('radio_id', auth()->user()->radio->id)->where('status', 1)->update([
            'status' => 0,
        ]);
        return redirect()->route('presenter_players');
    }

    public function online($index)
    {

        $data = [
            'new_players' => Players::where('id', '>', $index)->where('user_id', auth()->user()->id)->get(),
            // $active = Presenter_Sessions::where
            'totalAmount' => Players::where('TransTime', '>', auth()->user()->sessions->last()->created_at)->where('user_id', auth()->user()->id)->sum('TransAmount'),
        ];
        return $data;
        // return view('session');
        // return view('players');
    }

    // Admin routes
    public function presenters()
    {
        $presenters = Presenter::where('role', 'presenter')->get();
        return view('presenters', ['presenters' => $presenters, 'radios' => Radio::all()]);
    }
    public function add_presenter(Request $request)
    {
        Presenter::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'radio_id' => $request->radio_id,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('presenters');
    }
    public function update_presenter(Request $request, Presenter $presenter)
    {
        $presenter->update($request->all());
        return redirect()->route('presenters');
    }
    public function delete_presenter(Presenter $presenter)
    {
        $presenter->delete();
        return redirect()->route('presenters');
    }
}
